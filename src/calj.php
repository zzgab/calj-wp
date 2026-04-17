<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require __DIR__ . '/vendor/autoload.php';

use calj\wordpress\CalJSettingsPage;
use calj\wordpress\CalJPlugin;

/**
 * Plugin Name: CalJ Shabbat Times
 * Plugin URI: https://calj.net
 * Description: Add the Shabbat times on your site.
 * Version: 2.0
 * Author: Gabriel Zerbib <gabriel@calj.net>
 * Author URI: https://calj.net
 * License: GPL3
 */

is_admin() ? new CalJSettingsPage() : new CalJPlugin();
