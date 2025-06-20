<?php
namespace calj\wordpress;

if (defined('WP_UNINSTALL_PLUGIN') && constant('WP_UNINSTALL_PLUGIN')) {
	require_once __DIR__.'/CalJPlugin.php';
	require_once __DIR__.'/CalJSettingsPage.php';
	CalJPlugin::uninstall();
}
