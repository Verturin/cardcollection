<?php
/**
 *
 * Card Collection. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2024, Verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace verturin\cardcollection;

/**
 * Card Collection Extension base
 */
class ext extends \phpbb\extension\base
{
    /**
     * Check whether the extension can be enabled.
     *
     * @return bool
     */
    public function is_enableable()
    {
        // Require phpBB 3.3.0 or higher
        $config = $this->container->get('config');
        return phpbb_version_compare($config['version'], '3.3.0', '>=');
    }
}
