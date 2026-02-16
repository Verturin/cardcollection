<?php
/**
 *
 * Card Collection [English]
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
    'CARDS' => 'Cards',
    'CARD_COLLECTION' => 'Card Collection',
    'VIEWING_CARDS' => 'Viewing cards',
    
    // Index display
    'LATEST_CARDS_TITLE' => 'Latest Cards Added',
    'VIEW_ALL_CARDS' => 'View All Cards',
    'TOTAL_CARDS_COUNT' => [
        1 => '%d card',
        2 => '%d cards',
    ],
    'TOTAL_COLLECTORS_COUNT' => [
        1 => '%d collector',
        2 => '%d collectors',
    ],
    'JOIN_CARD_COMMUNITY' => '🎴 Join our collectors community!',
    'CARDS_CTA_DESCRIPTION' => 'Create your collection, trade with other members and discover new cards.',
    'NO_IMAGE' => 'No image',
    'BY' => 'by',
    'MY_COLLECTION' => 'My Collection',
    
    // Card details
    'CARD_PLAYER' => 'Player',
    'CARD_YEAR' => 'Year',
    'CARD_VERSION' => 'Version',
    'CARD_TITLE' => 'Title',
    'CARD_SERIES' => 'Series',
    'CARD_RARITY' => 'Rarity',
    'CARD_DESCRIPTION' => 'Description',
    'CARD_CODE' => 'Code',
    'CARD_EVENT' => 'Event',
    'PRINT_QUANTITY' => 'Print quantity',
    
    // Rarities
    'RARITY_COMMON' => 'Common',
    'RARITY_RARE' => 'Rare',
    'RARITY_ULTRA_RARE' => 'Ultra Rare',
    'RARITY_LEGENDARY' => 'Legendary',
    
    // Actions
    'VIEW_CARD' => 'View Card',
    'ADD_TO_COLLECTION' => 'Add to my collection',
    'ADD_TO_WANTLIST' => 'Add to my wantlist',
    'PROPOSE_TRADE' => 'Propose trade',
    
    // Collection
    'MY_CARDS' => 'My Cards',
    'MY_WANTLIST' => 'My Wantlist',
    'MY_TRADES' => 'My Trades',
    'MANAGE_COLLECTION' => 'Manage my collection',
    
    // Stats
    'CARDS_IN_COLLECTION' => 'Cards in my collection',
    'CARDS_IN_WANTLIST' => 'Cards wanted',
    'PENDING_TRADES' => 'Pending trades',
    
    // Messages
    'CARD_ADDED' => 'Card successfully added!',
    'CARD_UPDATED' => 'Card updated!',
    'CARD_DELETED' => 'Card deleted.',
    'NO_CARDS_FOUND' => 'No cards found.',
    'MUST_LOGIN_TO_VIEW' => 'You must be logged in to view this page.',
    
    // Permissions
    'ACL_U_CARDS_VIEW' => 'Can view cards',
    'ACL_U_CARDS_CREATE' => 'Can create cards',
    'ACL_U_CARDS_EDIT_OWN' => 'Can edit own cards',
    'ACL_U_CARDS_MANAGE_COLLECTION' => 'Can manage collection',
    'ACL_U_CARDS_TRADE' => 'Can propose trades',
    'ACL_M_CARDS_EDIT' => 'Can edit all cards',
    'ACL_M_CARDS_DELETE' => 'Can delete cards',
    'ACL_A_CARDS_MANAGE' => 'Can administrate cards',
]);
