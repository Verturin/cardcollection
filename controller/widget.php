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
 * Widget API Controller - Provides embeddable widget for external sites
 */
class widget
{
    /** @var \phpbb\db\driver\driver_interface */
    protected $db;

    /** @var \phpbb\config\config */
    protected $config;

    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\path_helper */
    protected $path_helper;

    /** @var string */
    protected $cards_table;

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
        \phpbb\path_helper $path_helper,
        $cards_table,
        $root_path,
        $php_ext
    )
    {
        $this->db = $db;
        $this->config = $config;
        $this->user = $user;
        $this->path_helper = $path_helper;
        $this->cards_table = $cards_table;
        $this->root_path = $root_path;
        $this->php_ext = $php_ext;
    }

    /**
     * Get widget data as JSON
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function get_data()
    {
        // Check if widget is enabled
        if (!$this->config['cards_enable_widget'])
        {
            return new \Symfony\Component\HttpFoundation\JsonResponse([
                'error' => 'Widget is disabled'
            ], 403);
        }

        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : (int) $this->config['cards_widget_limit'];
        $limit = min($limit, 24); // Max 24 cards

        // Get latest cards
        $sql = 'SELECT card_id, player_username, card_year, card_version, 
                       card_title, image_front, card_rarity, card_series, creation_time
                FROM ' . $this->cards_table . '
                ORDER BY creation_time DESC';
        $result = $this->db->sql_query_limit($sql, $limit);

        $cards = [];
        while ($row = $this->db->sql_fetchrow($result))
        {
            $cards[] = [
                'id' => (int) $row['card_id'],
                'player' => $row['player_username'],
                'year' => (int) $row['card_year'],
                'version' => $row['card_version'],
                'title' => $row['card_title'],
                'image' => $row['image_front'] ? $this->get_board_url() . 'files/cards/' . $row['image_front'] : null,
                'rarity' => $row['card_rarity'],
                'series' => $row['card_series'],
                'created' => (int) $row['creation_time'],
                'url' => $this->get_board_url() . 'app.' . $this->php_ext . '/cards/view/' . $row['card_id'],
            ];
        }
        $this->db->sql_freeresult($result);

        // Get stats
        $sql = 'SELECT COUNT(card_id) as total FROM ' . $this->cards_table;
        $result = $this->db->sql_query($sql);
        $total_cards = (int) $this->db->sql_fetchfield('total');
        $this->db->sql_freeresult($result);

        $response_data = [
            'success' => true,
            'cards' => $cards,
            'total_cards' => $total_cards,
            'forum_url' => $this->get_board_url(),
            'catalog_url' => $this->get_board_url() . 'app.' . $this->php_ext . '/cards/catalog',
            'register_url' => $this->get_board_url() . 'ucp.' . $this->php_ext . '?mode=register',
        ];

        // Allow CORS for widget embedding
        $response = new \Symfony\Component\HttpFoundation\JsonResponse($response_data);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET');
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }

    /**
     * Get widget JavaScript file
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function get_script()
    {
        // Check if widget is enabled
        if (!$this->config['cards_enable_widget'])
        {
            $response = new \Symfony\Component\HttpFoundation\Response('// Widget disabled', 200);
            $response->headers->set('Content-Type', 'application/javascript');
            return $response;
        }

        $api_url = $this->get_board_url() . 'app.' . $this->php_ext . '/cards/widget/data';

        $script = file_get_contents(__DIR__ . '/../assets/widget.js');
        $script = str_replace('{{API_URL}}', $api_url, $script);
        $script = str_replace('{{BOARD_URL}}', $this->get_board_url(), $script);

        $response = new \Symfony\Component\HttpFoundation\Response($script, 200);
        $response->headers->set('Content-Type', 'application/javascript; charset=utf-8');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Cache-Control', 'public, max-age=3600'); // 1 hour cache

        return $response;
    }

    /**
     * Get board URL
     *
     * @return string
     */
    private function get_board_url()
    {
        return generate_board_url() . '/';
    }
}
