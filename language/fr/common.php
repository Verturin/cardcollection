<?php
/**
 *
 * Card Collection [French]
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
    // Common
    'CARDS' => 'Cartes',
    'CARD_COLLECTION' => 'Collection de Cartes',
    'VIEWING_CARDS' => 'Consulte les cartes',
    
    // Index display
    'LATEST_CARDS_TITLE' => 'Dernières cartes ajoutées',
    'VIEW_ALL_CARDS' => 'Voir toutes les cartes',
    'TOTAL_CARDS_COUNT' => [
        1 => '%d carte',
        2 => '%d cartes',
    ],
    'TOTAL_COLLECTORS_COUNT' => [
        1 => '%d collectionneur',
        2 => '%d collectionneurs',
    ],
    'JOIN_CARD_COMMUNITY' => '🎴 Rejoignez notre communauté de collectionneurs !',
    'CARDS_CTA_DESCRIPTION' => 'Créez votre collection, échangez avec d\'autres membres et découvrez de nouvelles cartes.',
    'NO_IMAGE' => 'Pas d\'image',
    'BY' => 'par',
    'MY_COLLECTION' => 'Ma collection',
    
    // Card details
    'CARD_PLAYER' => 'Joueur',
    'CARD_YEAR' => 'Année',
    'CARD_VERSION' => 'Version',
    'CARD_TITLE' => 'Titre',
    'CARD_SERIES' => 'Série',
    'CARD_RARITY' => 'Rareté',
    'CARD_DESCRIPTION' => 'Description',
    'CARD_CODE' => 'Code',
    'CARD_EVENT' => 'Événement',
    'PRINT_QUANTITY' => 'Quantité imprimée',
    
    // Rarities
    'RARITY_COMMON' => 'Commune',
    'RARITY_RARE' => 'Rare',
    'RARITY_ULTRA_RARE' => 'Ultra Rare',
    'RARITY_LEGENDARY' => 'Légendaire',
    
    // Actions
    'VIEW_CARD' => 'Voir la carte',
    'ADD_TO_COLLECTION' => 'Ajouter à ma collection',
    'ADD_TO_WANTLIST' => 'Ajouter à ma mancolist',
    'PROPOSE_TRADE' => 'Proposer un échange',
    
    // Collection
    'MY_CARDS' => 'Mes cartes',
    'MY_WANTLIST' => 'Ma mancolist',
    'MY_TRADES' => 'Mes échanges',
    'MANAGE_COLLECTION' => 'Gérer ma collection',
    
    // Stats
    'CARDS_IN_COLLECTION' => 'Cartes dans ma collection',
    'CARDS_IN_WANTLIST' => 'Cartes recherchées',
    'PENDING_TRADES' => 'Échanges en attente',
    
    // Messages
    'CARD_ADDED' => 'Carte ajoutée avec succès !',
    'CARD_UPDATED' => 'Carte mise à jour !',
    'CARD_DELETED' => 'Carte supprimée.',
    'NO_CARDS_FOUND' => 'Aucune carte trouvée.',
    'MUST_LOGIN_TO_VIEW' => 'Vous devez être connecté pour voir cette page.',
    
    // Permissions
    'ACL_U_CARDS_VIEW' => 'Peut voir les cartes',
    'ACL_U_CARDS_CREATE' => 'Peut créer des cartes',
    'ACL_U_CARDS_EDIT_OWN' => 'Peut modifier ses propres cartes',
    'ACL_U_CARDS_MANAGE_COLLECTION' => 'Peut gérer sa collection',
    'ACL_U_CARDS_TRADE' => 'Peut proposer des échanges',
    'ACL_M_CARDS_EDIT' => 'Peut modifier toutes les cartes',
    'ACL_M_CARDS_DELETE' => 'Peut supprimer des cartes',
    'ACL_A_CARDS_MANAGE' => 'Peut administrer les cartes',
]);
