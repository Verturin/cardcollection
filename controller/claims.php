<?php
/**
 *
 * Card Collection. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2024, Card Collection Team
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace verturin\cardcollection\controller;

/**
 * Ownership Claims Controller - Handle card ownership claims
 */
class claims
{
    /** @var \phpbb\db\driver\driver_interface */
    protected $db;

    /** @var \phpbb\config\config */
    protected $config;

    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\auth\auth */
    protected $auth;

    /** @var \phpbb\template\template */
    protected $template;

    /** @var \phpbb\request\request */
    protected $request;

    /** @var string */
    protected $cards_table;

    /** @var string */
    protected $claims_table;

    /** @var string */
    protected $history_table;

    /** @var string */
    protected $users_table;

    /** @var string */
    protected $root_path;

    /** @var string */
    protected $php_ext;

    /**
     * Constructor
     */
    public function __construct(
        \phpbb\db\driver\driver_interface $db,
        \phpbb\config\config $config,
        \phpbb\user $user,
        \phpbb\auth\auth $auth,
        \phpbb\template\template $template,
        \phpbb\request\request $request,
        $cards_table,
        $claims_table,
        $history_table,
        $users_table,
        $root_path,
        $php_ext
    )
    {
        $this->db = $db;
        $this->config = $config;
        $this->user = $user;
        $this->auth = $auth;
        $this->template = $template;
        $this->request = $request;
        $this->cards_table = $cards_table;
        $this->claims_table = $claims_table;
        $this->history_table = $history_table;
        $this->users_table = $users_table;
        $this->root_path = $root_path;
        $this->php_ext = $php_ext;
    }

    /**
     * Submit a claim for card ownership
     *
     * @param int $card_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submit_claim($card_id)
    {
        // Check if user is logged in
        if ($this->user->data['user_id'] == ANONYMOUS)
        {
            trigger_error('NOT_AUTHORISED');
        }

        // Check permission
        if (!$this->auth->acl_get('u_cards_claim_ownership'))
        {
            trigger_error('NOT_AUTHORISED');
        }

        $card_id = (int) $card_id;

        // Get card info
        $sql = 'SELECT c.*, u.username as creator_name, u.user_email
                FROM ' . $this->cards_table . ' c
                LEFT JOIN ' . $this->users_table . ' u ON c.creator_user_id = u.user_id
                WHERE c.card_id = ' . $card_id;
        $result = $this->db->sql_query($sql);
        $card = $this->db->sql_fetchrow($result);
        $this->db->sql_freeresult($result);

        if (!$card)
        {
            trigger_error('CARD_NOT_FOUND');
        }

        // Check if user is already the creator
        if ($card['creator_user_id'] == $this->user->data['user_id'])
        {
            trigger_error($this->user->lang('ALREADY_CARD_CREATOR'));
        }

        // Check if there's already a pending claim from this user
        $sql = 'SELECT claim_id FROM ' . $this->claims_table . '
                WHERE card_id = ' . $card_id . '
                AND claimant_user_id = ' . (int) $this->user->data['user_id'] . '
                AND claim_status = \'pending\'';
        $result = $this->db->sql_query($sql);
        $existing_claim = $this->db->sql_fetchrow($result);
        $this->db->sql_freeresult($result);

        if ($existing_claim)
        {
            trigger_error($this->user->lang('CLAIM_ALREADY_PENDING'));
        }

        // Handle form submission
        if ($this->request->is_set_post('submit'))
        {
            $claim_message = $this->request->variable('claim_message', '', true);
            
            // Validate
            if (empty($claim_message) || strlen($claim_message) < 20)
            {
                trigger_error($this->user->lang('CLAIM_MESSAGE_TOO_SHORT'));
            }

            // Handle proof image upload
            $proof_image = '';
            if (isset($_FILES['proof_image']) && $_FILES['proof_image']['error'] == UPLOAD_ERR_OK)
            {
                $proof_image = $this->handle_proof_upload($_FILES['proof_image']);
            }
            else if ($this->config['cards_claim_require_proof'])
            {
                trigger_error($this->user->lang('CLAIM_PROOF_REQUIRED'));
            }

            // Insert claim
            $sql_ary = [
                'card_id' => $card_id,
                'claimant_user_id' => (int) $this->user->data['user_id'],
                'current_creator_id' => (int) $card['creator_user_id'],
                'claim_status' => 'pending',
                'claim_message' => $claim_message,
                'proof_image' => $proof_image,
                'claim_time' => time(),
            ];

            $sql = 'INSERT INTO ' . $this->claims_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
            $this->db->sql_query($sql);
            $claim_id = $this->db->sql_nextid();

            // Send notification to current creator
            if ($this->config['cards_claim_notify_creator'] && $card['creator_user_id'])
            {
                $this->send_claim_notification($card, $claim_id);
            }

            // Send notification to moderators
            $this->notify_moderators_new_claim($card, $claim_id);

            // Redirect with success message
            $message = $this->user->lang('CLAIM_SUBMITTED_SUCCESS');
            $url = append_sid("{$this->root_path}app.{$this->php_ext}/cards/view/$card_id");
            meta_refresh(3, $url);
            trigger_error($message . '<br><br>' . sprintf($this->user->lang('RETURN_PAGE'), '<a href="' . $url . '">', '</a>'));
        }

        // Display form
        $this->template->assign_vars([
            'CARD_ID' => $card_id,
            'CARD_PLAYER' => $card['player_username'],
            'CARD_YEAR' => $card['card_year'],
            'CARD_VERSION' => $card['card_version'],
            'CARD_TITLE' => $card['card_title'],
            'CURRENT_CREATOR' => $card['creator_name'],
            'REQUIRE_PROOF' => $this->config['cards_claim_require_proof'],
            'S_CLAIM_FORM' => true,
        ]);

        return $this->helper->render('claim_form.html', $this->user->lang('CLAIM_CARD_OWNERSHIP'));
    }

    /**
     * View claim details (for moderators)
     *
     * @param int $claim_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view_claim($claim_id)
    {
        // Check permission
        if (!$this->auth->acl_get('m_cards_review_claims'))
        {
            trigger_error('NOT_AUTHORISED');
        }

        $claim_id = (int) $claim_id;

        // Get claim details
        $sql = 'SELECT c.*, 
                       card.player_username, card.card_year, card.card_version, card.card_title, card.image_front,
                       claimant.username as claimant_name, claimant.user_email as claimant_email,
                       creator.username as creator_name, creator.user_email as creator_email,
                       reviewer.username as reviewer_name
                FROM ' . $this->claims_table . ' c
                LEFT JOIN ' . $this->cards_table . ' card ON c.card_id = card.card_id
                LEFT JOIN ' . $this->users_table . ' claimant ON c.claimant_user_id = claimant.user_id
                LEFT JOIN ' . $this->users_table . ' creator ON c.current_creator_id = creator.user_id
                LEFT JOIN ' . $this->users_table . ' reviewer ON c.reviewed_by = reviewer.user_id
                WHERE c.claim_id = ' . $claim_id;
        $result = $this->db->sql_query($sql);
        $claim = $this->db->sql_fetchrow($result);
        $this->db->sql_freeresult($result);

        if (!$claim)
        {
            trigger_error('CLAIM_NOT_FOUND');
        }

        // Handle approval/rejection
        if ($this->request->is_set_post('approve') || $this->request->is_set_post('reject'))
        {
            check_form_key('review_claim');

            $action = $this->request->is_set_post('approve') ? 'approved' : 'rejected';
            $review_notes = $this->request->variable('review_notes', '', true);

            // Update claim status
            $sql_ary = [
                'claim_status' => $action,
                'review_time' => time(),
                'reviewed_by' => (int) $this->user->data['user_id'],
                'review_notes' => $review_notes,
            ];

            $sql = 'UPDATE ' . $this->claims_table . '
                    SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
                    WHERE claim_id = ' . $claim_id;
            $this->db->sql_query($sql);

            if ($action === 'approved')
            {
                // Transfer ownership
                $this->transfer_ownership($claim['card_id'], $claim['current_creator_id'], $claim['claimant_user_id'], $claim_id, 'claim');
                
                // Notify claimant
                $this->notify_claim_approved($claim);
            }
            else
            {
                // Notify claimant of rejection
                $this->notify_claim_rejected($claim, $review_notes);
            }

            $message = $action === 'approved' ? 'CLAIM_APPROVED' : 'CLAIM_REJECTED';
            trigger_error($this->user->lang($message));
        }

        // Display claim details
        $this->template->assign_vars([
            'CLAIM_ID' => $claim_id,
            'CARD_PLAYER' => $claim['player_username'],
            'CARD_YEAR' => $claim['card_year'],
            'CARD_TITLE' => $claim['card_title'],
            'CLAIMANT_NAME' => $claim['claimant_name'],
            'CREATOR_NAME' => $claim['creator_name'],
            'CLAIM_MESSAGE' => $claim['claim_message'],
            'PROOF_IMAGE' => $claim['proof_image'],
            'CLAIM_TIME' => $this->user->format_date($claim['claim_time']),
            'CLAIM_STATUS' => $claim['claim_status'],
            'REVIEW_NOTES' => $claim['review_notes'],
            'REVIEWER_NAME' => $claim['reviewer_name'],
            'S_CAN_REVIEW' => $claim['claim_status'] === 'pending',
        ]);

        add_form_key('review_claim');

        return $this->helper->render('claim_review.html', $this->user->lang('REVIEW_CLAIM'));
    }

    /**
     * Transfer card ownership
     *
     * @param int $card_id
     * @param int $old_creator_id
     * @param int $new_creator_id
     * @param int $claim_id
     * @param string $reason
     */
    protected function transfer_ownership($card_id, $old_creator_id, $new_creator_id, $claim_id = 0, $reason = 'claim')
    {
        // Update card creator
        $sql = 'UPDATE ' . $this->cards_table . '
                SET creator_user_id = ' . (int) $new_creator_id . '
                WHERE card_id = ' . (int) $card_id;
        $this->db->sql_query($sql);

        // Add to history
        $sql_ary = [
            'card_id' => (int) $card_id,
            'old_creator_id' => (int) $old_creator_id,
            'new_creator_id' => (int) $new_creator_id,
            'change_reason' => $reason,
            'claim_id' => (int) $claim_id,
            'changed_by' => (int) $this->user->data['user_id'],
            'change_time' => time(),
            'notes' => 'Ownership transferred via claim system',
        ];

        $sql = 'INSERT INTO ' . $this->history_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
        $this->db->sql_query($sql);
    }

    /**
     * Handle proof image upload
     *
     * @param array $file
     * @return string Filename
     */
    protected function handle_proof_upload($file)
    {
        $upload_dir = $this->root_path . 'files/cards/proofs/';
        
        if (!file_exists($upload_dir))
        {
            mkdir($upload_dir, 0755, true);
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types))
        {
            trigger_error('INVALID_FILE_TYPE');
        }

        if ($file['size'] > 5 * 1024 * 1024) // 5MB
        {
            trigger_error('FILE_TOO_LARGE');
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'proof_' . time() . '_' . uniqid() . '.' . $ext;
        $filepath = $upload_dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $filepath))
        {
            trigger_error('UPLOAD_FAILED');
        }

        return $filename;
    }

    /**
     * Send notification to current creator about claim
     */
    protected function send_claim_notification($card, $claim_id)
    {
        // Implementation depends on phpBB notification system
        // This is a placeholder
    }

    /**
     * Notify moderators about new claim
     */
    protected function notify_moderators_new_claim($card, $claim_id)
    {
        // Implementation depends on phpBB notification system
    }

    /**
     * Notify claimant that claim was approved
     */
    protected function notify_claim_approved($claim)
    {
        // Implementation depends on phpBB notification system
    }

    /**
     * Notify claimant that claim was rejected
     */
    protected function notify_claim_rejected($claim, $reason)
    {
        // Implementation depends on phpBB notification system
    }
}
