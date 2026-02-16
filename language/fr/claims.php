<?php
/**
 *
 * Card Collection - Ownership Claims [French]
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
    'CLAIM_CARD_OWNERSHIP' => 'Revendiquer la propriété de cette carte',
    'CLAIM_OWNERSHIP_BUTTON' => 'Je suis le créateur de cette carte',
    'CLAIM_FORM_TITLE' => 'Revendiquer la création de cette carte',
    'CLAIM_FORM_EXPLANATION' => 'Cette carte a été ajoutée par un autre membre. Si vous êtes le véritable créateur de cette carte, vous pouvez revendiquer sa propriété.',
    'CLAIM_MESSAGE_LABEL' => 'Expliquez pourquoi vous êtes le créateur',
    'CLAIM_MESSAGE_PLACEHOLDER' => 'Exemple : "J\'ai créé cette carte pour le Mega Event de Paris 2022. C\'est moi qui ai distribué ces cartes lors de l\'événement..."',
    'CLAIM_MESSAGE_TOO_SHORT' => 'Votre message doit contenir au moins 20 caractères pour expliquer votre revendication.',
    'CLAIM_PROOF_LABEL' => 'Photo de preuve (optionnel mais recommandé)',
    'CLAIM_PROOF_HELP' => 'Une photo vous montrant avec les cartes, ou le fichier source, ou une photo de l\'événement',
    'CLAIM_PROOF_REQUIRED' => 'Une preuve (photo) est requise pour revendiquer cette carte.',
    'CLAIM_SUBMIT_BUTTON' => 'Soumettre ma revendication',
    'CLAIM_SUBMITTED_SUCCESS' => 'Votre revendication a été soumise avec succès. Un modérateur va l\'examiner.',
    
    // Current creator info
    'CURRENT_CREATOR_INFO' => 'Créateur actuel',
    'CURRENT_CREATOR_NOTE' => 'Le créateur actuel sera notifié de votre revendication.',
    'COLLECTIONS_NOT_AFFECTED' => 'Important : Les collections des autres utilisateurs ne seront PAS affectées. Seul le créateur de la carte changera.',
    
    // Claim status
    'CLAIM_STATUS_PENDING' => 'En attente',
    'CLAIM_STATUS_APPROVED' => 'Approuvée',
    'CLAIM_STATUS_REJECTED' => 'Refusée',
    'YOUR_CLAIM_PENDING' => 'Votre revendication est en attente de validation',
    'YOUR_CLAIM_APPROVED' => 'Votre revendication a été approuvée ! Vous êtes maintenant le créateur officiel.',
    'YOUR_CLAIM_REJECTED' => 'Votre revendication a été refusée.',
    
    // Errors
    'ALREADY_CARD_CREATOR' => 'Vous êtes déjà le créateur de cette carte.',
    'CLAIM_ALREADY_PENDING' => 'Vous avez déjà une revendication en attente pour cette carte.',
    'CLAIM_NOT_FOUND' => 'Revendication introuvable.',
    'CARD_NOT_FOUND' => 'Carte introuvable.',
    'INVALID_FILE_TYPE' => 'Type de fichier non autorisé. Utilisez JPG, PNG ou GIF.',
    'FILE_TOO_LARGE' => 'Le fichier est trop volumineux (max 5 MB).',
    'UPLOAD_FAILED' => 'Échec de l\'upload du fichier.',
    
    // Moderation
    'REVIEW_CLAIM' => 'Examiner la revendication',
    'CLAIM_DETAILS' => 'Détails de la revendication',
    'CLAIMANT' => 'Demandeur',
    'CLAIM_DATE' => 'Date de la revendication',
    'CLAIM_REASON' => 'Raison de la revendication',
    'PROOF_PROVIDED' => 'Preuve fournie',
    'NO_PROOF_PROVIDED' => 'Aucune preuve fournie',
    'VIEW_PROOF' => 'Voir la preuve',
    'REVIEW_NOTES_LABEL' => 'Notes de révision (optionnel)',
    'REVIEW_NOTES_PLACEHOLDER' => 'Raison de votre décision...',
    'APPROVE_CLAIM' => 'Approuver la revendication',
    'REJECT_CLAIM' => 'Rejeter la revendication',
    'CLAIM_APPROVED' => 'Revendication approuvée. La propriété de la carte a été transférée.',
    'CLAIM_REJECTED' => 'Revendication rejetée.',
    
    // History
    'OWNERSHIP_HISTORY' => 'Historique de propriété',
    'OWNERSHIP_TRANSFERRED' => 'Propriété transférée',
    'TRANSFER_REASON_CLAIM' => 'Revendication approuvée',
    'TRANSFER_REASON_ADMIN' => 'Correction par administrateur',
    'TRANSFER_REASON_CORRECTION' => 'Correction',
    'FROM' => 'De',
    'TO' => 'À',
    'CHANGED_BY' => 'Modifié par',
    'CHANGE_DATE' => 'Date du changement',
    
    // Notifications
    'NOTIFICATION_CLAIM_SUBMITTED' => '%s revendique la création de votre carte "%s"',
    'NOTIFICATION_CLAIM_APPROVED' => 'Votre revendication pour la carte "%s" a été approuvée',
    'NOTIFICATION_CLAIM_REJECTED' => 'Votre revendication pour la carte "%s" a été refusée',
    'NOTIFICATION_OWNERSHIP_CHANGED' => 'La propriété de votre carte "%s" a été transférée',
    
    // Permissions
    'ACL_U_CARDS_CLAIM_OWNERSHIP' => 'Peut revendiquer la propriété de cartes',
    'ACL_M_CARDS_REVIEW_CLAIMS' => 'Peut examiner les revendications de propriété',
    
    // Widget on card view
    'NOT_THE_CREATOR' => 'Vous n\'êtes pas le créateur ?',
    'CLAIM_THIS_CARD' => 'Revendiquer cette carte',
    
    // ACP
    'ACP_CLAIMS_PENDING' => 'Revendications en attente',
    'ACP_CLAIMS_ALL' => 'Toutes les revendications',
    'ACP_CLAIMS_SETTINGS' => 'Paramètres des revendications',
    'ACP_CLAIM_REQUIRE_PROOF' => 'Exiger une preuve (photo)',
    'ACP_CLAIM_AUTO_APPROVE_TIME' => 'Auto-approuver après X jours si créateur inactif',
    'ACP_CLAIM_NOTIFY_CREATOR' => 'Notifier l\'ancien créateur',
]);
