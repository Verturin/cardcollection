<?php
/**
 *
 * Card Collection. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2024, Verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace verturin\cardcollection\migrations;

class v1_0_0_base extends \phpbb\db\migration\migration
{
    public function effectively_installed()
    {
        return $this->db_tools->sql_table_exists($this->table_prefix . 'cards');
    }

    static public function depends_on()
    {
        return ['\phpbb\db\migration\data\v320\v320'];
    }

    public function update_schema()
    {
        return [
            'add_tables' => [
                $this->table_prefix . 'cards' => [
                    'COLUMNS' => [
                        'card_id' => ['UINT', null, 'auto_increment'],
                        'player_username' => ['VCHAR:100', ''],
                        'card_year' => ['UINT', 0],
                        'card_version' => ['VCHAR:50', 'v1'],
                        'card_title' => ['VCHAR:200', ''],
                        'card_description' => ['TEXT', ''],
                        'image_front' => ['VCHAR:255', ''],
                        'image_front_pdf' => ['VCHAR:255', ''],
                        'image_back' => ['VCHAR:255', ''],
                        'image_back_pdf' => ['VCHAR:255', ''],
                        'card_code' => ['VCHAR:50', ''],
                        'card_event' => ['VCHAR:200', ''],
                        'card_series' => ['VCHAR:100', ''],
                        'card_rarity' => ['VCHAR:20', 'common'],
                        'print_quantity' => ['UINT', 0],
                        'creator_user_id' => ['UINT', 0],
                        'creation_time' => ['TIMESTAMP', 0],
                    ],
                    'PRIMARY_KEY' => 'card_id',
                    'KEYS' => [
                        'player_year_ver' => ['UNIQUE', ['player_username', 'card_year', 'card_version']],
                        'player_username' => ['INDEX', 'player_username'],
                        'card_year' => ['INDEX', 'card_year'],
                        'card_series' => ['INDEX', 'card_series'],
                        'creator_user_id' => ['INDEX', 'creator_user_id'],
                        'creation_time' => ['INDEX', 'creation_time'],
                    ],
                ],
                
                $this->table_prefix . 'card_collections' => [
                    'COLUMNS' => [
                        'collection_id' => ['UINT', null, 'auto_increment'],
                        'user_id' => ['UINT', 0],
                        'card_id' => ['UINT', 0],
                        'quantity' => ['UINT', 1],
                        'for_trade' => ['BOOL', 0],
                        'comment' => ['TEXT', ''],
                        'added_time' => ['TIMESTAMP', 0],
                    ],
                    'PRIMARY_KEY' => 'collection_id',
                    'KEYS' => [
                        'user_card' => ['UNIQUE', ['user_id', 'card_id']],
                        'user_id' => ['INDEX', 'user_id'],
                        'card_id' => ['INDEX', 'card_id'],
                        'for_trade' => ['INDEX', 'for_trade'],
                    ],
                ],
                
                $this->table_prefix . 'card_wantlists' => [
                    'COLUMNS' => [
                        'wantlist_id' => ['UINT', null, 'auto_increment'],
                        'user_id' => ['UINT', 0],
                        'card_id' => ['UINT', 0],
                        'priority' => ['VCHAR:20', 'medium'],
                        'comment' => ['TEXT', ''],
                        'added_time' => ['TIMESTAMP', 0],
                    ],
                    'PRIMARY_KEY' => 'wantlist_id',
                    'KEYS' => [
                        'user_card' => ['UNIQUE', ['user_id', 'card_id']],
                        'user_id' => ['INDEX', 'user_id'],
                        'card_id' => ['INDEX', 'card_id'],
                        'priority' => ['INDEX', 'priority'],
                    ],
                ],
                
                $this->table_prefix . 'card_trades' => [
                    'COLUMNS' => [
                        'trade_id' => ['UINT', null, 'auto_increment'],
                        'proposer_user_id' => ['UINT', 0],
                        'receiver_user_id' => ['UINT', 0],
                        'trade_status' => ['VCHAR:20', 'pending'],
                        'trade_message' => ['TEXT', ''],
                        'proposed_time' => ['TIMESTAMP', 0],
                        'response_time' => ['TIMESTAMP', 0],
                    ],
                    'PRIMARY_KEY' => 'trade_id',
                    'KEYS' => [
                        'proposer_user_id' => ['INDEX', 'proposer_user_id'],
                        'receiver_user_id' => ['INDEX', 'receiver_user_id'],
                        'trade_status' => ['INDEX', 'trade_status'],
                    ],
                ],
                
                $this->table_prefix . 'card_trade_items' => [
                    'COLUMNS' => [
                        'trade_item_id' => ['UINT', null, 'auto_increment'],
                        'trade_id' => ['UINT', 0],
                        'card_id' => ['UINT', 0],
                        'owner_user_id' => ['UINT', 0],
                        'quantity' => ['UINT', 1],
                        'item_type' => ['VCHAR:10', 'offer'],
                    ],
                    'PRIMARY_KEY' => 'trade_item_id',
                    'KEYS' => [
                        'trade_id' => ['INDEX', 'trade_id'],
                        'card_id' => ['INDEX', 'card_id'],
                    ],
                ],
                
                $this->table_prefix . 'card_ownership_claims' => [
                    'COLUMNS' => [
                        'claim_id' => ['UINT', null, 'auto_increment'],
                        'card_id' => ['UINT', 0],
                        'claimant_user_id' => ['UINT', 0],
                        'current_creator_id' => ['UINT', 0],
                        'claim_status' => ['VCHAR:20', 'pending'],
                        'claim_message' => ['TEXT', ''],
                        'proof_image' => ['VCHAR:255', ''],
                        'claim_time' => ['TIMESTAMP', 0],
                        'review_time' => ['TIMESTAMP', 0],
                        'reviewed_by' => ['UINT', 0],
                        'review_notes' => ['TEXT', ''],
                    ],
                    'PRIMARY_KEY' => 'claim_id',
                    'KEYS' => [
                        'card_id' => ['INDEX', 'card_id'],
                        'claimant_user_id' => ['INDEX', 'claimant_user_id'],
                        'claim_status' => ['INDEX', 'claim_status'],
                    ],
                ],
                
                $this->table_prefix . 'card_ownership_history' => [
                    'COLUMNS' => [
                        'history_id' => ['UINT', null, 'auto_increment'],
                        'card_id' => ['UINT', 0],
                        'old_creator_id' => ['UINT', 0],
                        'new_creator_id' => ['UINT', 0],
                        'change_reason' => ['VCHAR:50', 'claim'],
                        'claim_id' => ['UINT', 0],
                        'changed_by' => ['UINT', 0],
                        'change_time' => ['TIMESTAMP', 0],
                        'notes' => ['TEXT', ''],
                    ],
                    'PRIMARY_KEY' => 'history_id',
                    'KEYS' => [
                        'card_id' => ['INDEX', 'card_id'],
                        'old_creator_id' => ['INDEX', 'old_creator_id'],
                        'new_creator_id' => ['INDEX', 'new_creator_id'],
                    ],
                ],
            ],
        ];
    }

    public function revert_schema()
    {
        return [
            'drop_tables' => [
                $this->table_prefix . 'cards',
                $this->table_prefix . 'card_collections',
                $this->table_prefix . 'card_wantlists',
                $this->table_prefix . 'card_trades',
                $this->table_prefix . 'card_trade_items',
                $this->table_prefix . 'card_ownership_claims',
                $this->table_prefix . 'card_ownership_history',
            ],
        ];
    }

    public function update_data()
    {
        return [
            // Add permissions
            ['permission.add', ['u_cards_view', false]],
            ['permission.add', ['u_cards_create', false]],
            ['permission.add', ['u_cards_edit_own', false]],
            ['permission.add', ['u_cards_manage_collection', false]],
            ['permission.add', ['u_cards_trade', false]],
            ['permission.add', ['u_cards_claim_ownership', false]],
            ['permission.add', ['m_cards_edit', false]],
            ['permission.add', ['m_cards_delete', false]],
            ['permission.add', ['m_cards_review_claims', false]],
            ['permission.add', ['a_cards_manage', false]],

            // Set default permissions
            ['permission.permission_set', ['REGISTERED', 'u_cards_view', 'group']],
            ['permission.permission_set', ['REGISTERED', 'u_cards_create', 'group']],
            ['permission.permission_set', ['REGISTERED', 'u_cards_edit_own', 'group']],
            ['permission.permission_set', ['REGISTERED', 'u_cards_manage_collection', 'group']],
            ['permission.permission_set', ['REGISTERED', 'u_cards_trade', 'group']],
            ['permission.permission_set', ['REGISTERED', 'u_cards_claim_ownership', 'group']],

            // Add config values
            ['config.add', ['cards_per_page', 24]],
            ['config.add', ['cards_enable_trades', 1]],
            ['config.add', ['cards_enable_pdf', 1]],
            ['config.add', ['cards_max_file_size', 10485760]],
            ['config.add', ['cards_upload_path', 'files/cards']],
            ['config.add', ['cards_show_on_index', 1]],
            ['config.add', ['cards_index_limit', 6]],
            ['config.add', ['cards_index_position', 'after_online']],
            ['config.add', ['cards_enable_widget', 1]],
            ['config.add', ['cards_widget_limit', 6]],
            ['config.add', ['cards_widget_cache_time', 3600]],
            ['config.add', ['cards_claim_require_proof', 1]],
            ['config.add', ['cards_claim_auto_approve_time', 7]],
            ['config.add', ['cards_claim_notify_creator', 1]],
        ];
    }
}
