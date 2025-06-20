<?php
namespace calj\wordpress;

/**
 * Plugin Name: CalJ
 * Plugin URI: https://calj.net
 * Description: Add the Shabbat times on your site.
 * Version: 1.5
 * Author: Gabriel Zerbib <gabriel@calj.net>
 * Author URI: https://calj.net
 * Licence: GPL3
 */

require_once __DIR__.'/CalJPlugin.php';
require_once __DIR__.'/CalJSettingsPage.php';

is_admin() ? new CalJSettingsPage() : new CalJPlugin();
