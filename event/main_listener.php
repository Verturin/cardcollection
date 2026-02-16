<?php
/**
 *
 * Card Collection. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2024, Card Collection Team
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace verturin\cardcollection\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{
    /** @var \phpbb\template\template */
    protected $template;

    /** @var \phpbb\db\driver\driver_interface */
    protected $db;

    /** @var \phpbb\config\config */
    protected $config;

    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\path_helper */
    protected $path_helper;

    /** @var string */
    protected $php_ext;

    /** @var string */
    protected $cards_table;

    /** @var string */
    protected $users_table;

    /**
     * Constructor
     */
    public function __construct(
        \phpbb\template\template $template,
        \phpbb\db\driver\driver_interface $db,
        \phpbb\config\config $config,
        \phpbb\user $user,
        \phpbb\path_helper $path_helper,
        $php_ext,
        $cards_table,
        $users_table
    )
    {
        $this->template = $template;
        $this->db = $db;
        $this->config = $config;
        $this->user = $user;
        $this->path_helper = $path_helper;
        $this->php_ext = $php_ext;
        $this->cards_table = $cards_table;
        $this->users_table = $users_table;
    }

    /**
     * Assign functions defined in this class to event listeners in the core
     *
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return [
            'core.index_modify_page_title' => 'display_latest_cards_index',
            'core.viewonline_overwrite_location' => 'add_page_viewonline',
            'core.permissions' => 'add_permissions',
        ];
    }

    /**
     * Display latest cards on forum index
     *
     * @param object $event The event object
     */
    public function display_latest_cards_index($event)
    {
        // Check if feature is enabled
        if (!$this->config['cards_show_on_index'])
        {
            return;
        }

        $limit = (int) $this->config['cards_index_limit'];
        if ($limit <= 0)
        {
            $limit = 6;
        }

        // Get latest cards
        $sql = 'SELECT c.card_id, c.player_username, c.card_year, c.card_version, 
                       c.card_title, c.image_front, c.card_rarity, c.card_series,
                       c.creation_time, u.user_id, u.username, u.user_colour
                FROM ' . $this->cards_table . ' c
                LEFT JOIN ' . $this->users_table . ' u ON c.creator_user_id = u.user_id
                ORDER BY c.creation_time DESC';
        $result = $this->db->sql_query_limit($sql, $limit);

        $cards = [];
        while ($row = $this->db->sql_fetchrow($result))
        {
            $cards[] = [
                'CARD_ID' => $row['card_id'],
                'PLAYER_USERNAME' => $row['player_username'],
                'CARD_YEAR' => $row['card_year'],
                'CARD_VERSION' => $row['card_version'],
                'CARD_TITLE' => $row['card_title'],
                'IMAGE_FRONT' => $row['image_front'],
                'CARD_RARITY' => $row['card_rarity'],
                'CARD_SERIES' => $row['card_series'],
                'CREATION_TIME' => $this->user->format_date($row['creation_time']),
                'CREATOR_USERNAME' => $row['username'],
                'CREATOR_COLOUR' => $row['user_colour'],
                'U_CARD_VIEW' => append_sid("{$this->path_helper->get_phpbb_root_path()}app.{$this->php_ext}/cards/view/{$row['card_id']}"),
                'U_CREATOR_PROFILE' => $row['user_id'] ? append_sid("{$this->path_helper->get_phpbb_root_path()}memberlist.{$this->php_ext}", "mode=viewprofile&u={$row['user_id']}") : '',
            ];
        }
        $this->db->sql_freeresult($result);

        // Get total cards count
        $sql = 'SELECT COUNT(card_id) as total FROM ' . $this->cards_table;
        $result = $this->db->sql_query($sql);
        $total_cards = (int) $this->db->sql_fetchfield('total');
        $this->db->sql_freeresult($result);

        // Get total collectors count
        $sql = 'SELECT COUNT(DISTINCT user_id) as total 
                FROM ' . $this->db->get_sql_layer() . '_card_collections';
        $result = $this->db->sql_query($sql);
        $total_collectors = (int) $this->db->sql_fetchfield('total');
        $this->db->sql_freeresult($result);

        // Assign template variables
        $this->template->assign_vars([
            'CARDS_ENABLED' => true,
            'CARDS_SHOW_BLOCK' => true,
            'TOTAL_CARDS' => $total_cards,
            'TOTAL_COLLECTORS' => $total_collectors,
            'U_CARDS_CATALOG' => append_sid("{$this->path_helper->get_phpbb_root_path()}app.{$this->php_ext}/cards/catalog"),
            'U_CARDS_REGISTER' => append_sid("{$this->path_helper->get_phpbb_root_path()}ucp.{$this->php_ext}", 'mode=register'),
            'L_LATEST_CARDS_TITLE' => $this->user->lang('LATEST_CARDS_TITLE'),
            'L_VIEW_ALL_CARDS' => $this->user->lang('VIEW_ALL_CARDS'),
            'L_TOTAL_CARDS' => $this->user->lang('TOTAL_CARDS_COUNT', $total_cards),
            'L_TOTAL_COLLECTORS' => $this->user->lang('TOTAL_COLLECTORS_COUNT', $total_collectors),
            'L_JOIN_COMMUNITY' => $this->user->lang('JOIN_CARD_COMMUNITY'),
        ]);

        foreach ($cards as $card)
        {
            $this->template->assign_block_vars('latest_cards', $card);
        }
    }

    /**
     * Show users viewing cards in "who is online"
     *
     * @param object $event The event object
     */
    public function add_page_viewonline($event)
    {
        if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/cards') === 0)
        {
            $event['location'] = $this->user->lang('VIEWING_CARDS');
            $event['location_url'] = append_sid("{$this->path_helper->get_phpbb_root_path()}app.{$this->php_ext}/cards/catalog");
        }
    }

    /**
     * Add permissions
     *
     * @param object $event The event object
     */
    public function add_permissions($event)
    {
        $permissions = $event['permissions'];
        $permissions['u_cards_view'] = ['lang' => 'ACL_U_CARDS_VIEW', 'cat' => 'misc'];
        $permissions['u_cards_create'] = ['lang' => 'ACL_U_CARDS_CREATE', 'cat' => 'misc'];
        $permissions['u_cards_edit_own'] = ['lang' => 'ACL_U_CARDS_EDIT_OWN', 'cat' => 'misc'];
        $permissions['u_cards_manage_collection'] = ['lang' => 'ACL_U_CARDS_MANAGE_COLLECTION', 'cat' => 'misc'];
        $permissions['u_cards_trade'] = ['lang' => 'ACL_U_CARDS_TRADE', 'cat' => 'misc'];
        $permissions['m_cards_edit'] = ['lang' => 'ACL_M_CARDS_EDIT', 'cat' => 'misc'];
        $permissions['m_cards_delete'] = ['lang' => 'ACL_M_CARDS_DELETE', 'cat' => 'misc'];
        $permissions['a_cards_manage'] = ['lang' => 'ACL_A_CARDS_MANAGE', 'cat' => 'misc'];
        $event['permissions'] = $permissions;
    }
}
