<?php
require __DIR__ . '/vendor/autoload.php';

use calj\wordpress\CalJPlugin;

if (defined('WP_UNINSTALL_PLUGIN') && constant('WP_UNINSTALL_PLUGIN')) {
	CalJPlugin::uninstall();
}
