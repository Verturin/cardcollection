<?php
/**
 *
 * Card Collection - Ownership Claims [English]
 *
 * @copyright (c) 2024, Card Collection Team
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = [];
}

$lang = array_merge($lang, [
    // Ownership Claims
    'CLAIM_CARD_OWNERSHIP' => 'Claim ownership of this card',
    'CLAIM_OWNERSHIP_BUTTON' => 'I am the creator of this card',
    'CLAIM_FORM_TITLE' => 'Claim creation of this card',
    'CLAIM_FORM_EXPLANATION' => 'This card was added by another member. If you are the actual creator of this card, you can claim its ownership.',
    'CLAIM_MESSAGE_LABEL' => 'Explain why you are the creator',
    'CLAIM_MESSAGE_PLACEHOLDER' => 'Example: "I created this card for the Paris Mega Event 2022. I distributed these cards during the event..."',
    'CLAIM_MESSAGE_TOO_SHORT' => 'Your message must contain at least 20 characters to explain your claim.',
    'CLAIM_PROOF_LABEL' => 'Proof photo (optional but recommended)',
    'CLAIM_PROOF_HELP' => 'A photo of you with the cards, or the source file, or a photo from the event',
    'CLAIM_PROOF_REQUIRED' => 'Proof (photo) is required to claim this card.',
    'CLAIM_SUBMIT_BUTTON' => 'Submit my claim',
    'CLAIM_SUBMITTED_SUCCESS' => 'Your claim has been submitted successfully. A moderator will review it.',
    
    // Current creator info
    'CURRENT_CREATOR_INFO' => 'Current creator',
    'CURRENT_CREATOR_NOTE' => 'The current creator will be notified of your claim.',
    'COLLECTIONS_NOT_AFFECTED' => 'Important: Other users\' collections will NOT be affected. Only the card creator will change.',
    
    // Claim status
    'CLAIM_STATUS_PENDING' => 'Pending',
    'CLAIM_STATUS_APPROVED' => 'Approved',
    'CLAIM_STATUS_REJECTED' => 'Rejected',
    'YOUR_CLAIM_PENDING' => 'Your claim is pending validation',
    'YOUR_CLAIM_APPROVED' => 'Your claim has been approved! You are now the official creator.',
    'YOUR_CLAIM_REJECTED' => 'Your claim has been rejected.',
    
    // Errors
    'ALREADY_CARD_CREATOR' => 'You are already the creator of this card.',
    'CLAIM_ALREADY_PENDING' => 'You already have a pending claim for this card.',
    'CLAIM_NOT_FOUND' => 'Claim not found.',
    'CARD_NOT_FOUND' => 'Card not found.',
    'INVALID_FILE_TYPE' => 'Invalid file type. Use JPG, PNG or GIF.',
    'FILE_TOO_LARGE' => 'File is too large (max 5 MB).',
    'UPLOAD_FAILED' => 'File upload failed.',
    
    // Moderation
    'REVIEW_CLAIM' => 'Review claim',
    'CLAIM_DETAILS' => 'Claim details',
    'CLAIMANT' => 'Claimant',
    'CLAIM_DATE' => 'Claim date',
    'CLAIM_REASON' => 'Claim reason',
    'PROOF_PROVIDED' => 'Proof provided',
    'NO_PROOF_PROVIDED' => 'No proof provided',
    'VIEW_PROOF' => 'View proof',
    'REVIEW_NOTES_LABEL' => 'Review notes (optional)',
    'REVIEW_NOTES_PLACEHOLDER' => 'Reason for your decision...',
    'APPROVE_CLAIM' => 'Approve claim',
    'REJECT_CLAIM' => 'Reject claim',
    'CLAIM_APPROVED' => 'Claim approved. Card ownership has been transferred.',
    'CLAIM_REJECTED' => 'Claim rejected.',
    
    // History
    'OWNERSHIP_HISTORY' => 'Ownership history',
    'OWNERSHIP_TRANSFERRED' => 'Ownership transferred',
    'TRANSFER_REASON_CLAIM' => 'Approved claim',
    'TRANSFER_REASON_ADMIN' => 'Admin correction',
    'TRANSFER_REASON_CORRECTION' => 'Correction',
    'FROM' => 'From',
    'TO' => 'To',
    'CHANGED_BY' => 'Changed by',
    'CHANGE_DATE' => 'Change date',
    
    // Notifications
    'NOTIFICATION_CLAIM_SUBMITTED' => '%s claims creation of your card "%s"',
    'NOTIFICATION_CLAIM_APPROVED' => 'Your claim for card "%s" has been approved',
    'NOTIFICATION_CLAIM_REJECTED' => 'Your claim for card "%s" has been rejected',
    'NOTIFICATION_OWNERSHIP_CHANGED' => 'Ownership of your card "%s" has been transferred',
    
    // Permissions
    'ACL_U_CARDS_CLAIM_OWNERSHIP' => 'Can claim card ownership',
    'ACL_M_CARDS_REVIEW_CLAIMS' => 'Can review ownership claims',
    
    // Widget on card view
    'NOT_THE_CREATOR' => 'Not the creator?',
    'CLAIM_THIS_CARD' => 'Claim this card',
    
    // ACP
    'ACP_CLAIMS_PENDING' => 'Pending claims',
    'ACP_CLAIMS_ALL' => 'All claims',
    'ACP_CLAIMS_SETTINGS' => 'Claim settings',
    'ACP_CLAIM_REQUIRE_PROOF' => 'Require proof (photo)',
    'ACP_CLAIM_AUTO_APPROVE_TIME' => 'Auto-approve after X days if creator inactive',
    'ACP_CLAIM_NOTIFY_CREATOR' => 'Notify previous creator',
]);
