<?php
namespace calj\wordpress;

class CalJSettingsPage
{

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		if(isset($_POST['calj-clear-cache']) && $_POST['calj-clear-cache']) {
			ob_end_clean();
			add_option( CalJPlugin::SHABBAT_CACHE_OPTION, array(), '', 'no');
			update_option( CalJPlugin::SHABBAT_CACHE_OPTION, array());
			echo json_encode(array('success' => true));
			exit;
		}

		if(isset($_POST['calj-op']) && ($_POST['calj-op'] == 'save-obtained-key')) {
			$key = $_POST['calj-key'];
			ob_end_clean();
			$this->options = get_option( CalJPlugin::CALJ_API_OPTION );
			$this->options['api_key'] = $key;
			update_option( CalJPlugin::CALJ_API_OPTION, $this->options);
			update_option( CalJPlugin::SHABBAT_CACHE_OPTION, array());
			echo json_encode(array('success' => true, 'calj-key' => $key));
			exit;
		}

		// Register seed
		add_option ( 'wpcjseed',
			mt_rand(100000, 999999).'-'.mt_rand(100000, 999999).'-'.mt_rand(100000, 999999).
			'-'.mt_rand(100000, 999999).'-'.mt_rand(100000, 999999).'-'.mt_rand(100000, 999999),
			'', 'no' );


		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );

		add_filter( 'plugin_action_links', array($this, 'pluginActionLinks'), 10, 2);
	}

	public function pluginActionLinks($links, $file)
	{
		if (dirname(plugin_basename(__FILE__)) != dirname($file)) return $links;
		$links[] = '<a href="options-general.php?page=calj-setting">' . __('Settings') . '</a>';
		return $links;
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_options_page(
			'Settings Admin',
			'CalJ',
			'manage_options',
			'calj-setting',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( CalJPlugin::CALJ_API_OPTION );
		?>
		<div class="wrap">
			<h2>CalJ Settings
				<a class="button-calj-clear-chache-now page-title-action" href="<?php echo $_SERVER['REQUEST_URI'];?>&clear-calj-cache=1">Clear Cache Now</a>
				<span class="calj-ok-cache-cleared" style="color: #159E15; font-size: 12px; visibility: hidden;">OK - Cache Cleared.</span>
			</h2>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'my_option_group' );
				do_settings_sections( 'calj-setting' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public function print_section_info()
	{
		// Make sure ThickBox is loaded
		add_thickbox();

		$hashing = md5(get_option('wpcjseed'));
		$cacheBuster = mt_rand();
		$siteUrl = urlencode(get_option('siteurl'));

		print '<a href="https://www.calj.net/api/wp-obtain.html?_='.$cacheBuster.'&hashing='.$hashing.'&siteurl='.$siteUrl.
			'&TB_iframe=true&width=600&height=550" title="CalJ API Key" class="thickbox button button-primary button-calj-obtain-key" target="_blank">Obtain a Key</a>';

        print '<br>';
        print "<div>⚠️ NOTE: you must install the plugin on your target (final/production) WordPress instance (Website URL)
for the registered key to work. If you register a key for a test/staging website URL, the key will
only work for that Referrer. You may register different keys if you have more than one environment.</div>";

		print <<<'ENDSCRIPT'
<script>
jQuery(function () {

  function caljApiObtainListener (msg) {
    if(undefined != msg.data.caljApiKey) {
      jQuery("#calj_api_key").val(msg.data.caljApiKey);
      // Save data
      jQuery.ajax({
        url: document.location.href,
        type: "POST",
        data: {
          "calj-op": "save-obtained-key",
          "calj-key": msg.data.caljApiKey
        }
      });
    }
    if (undefined != msg.data.caljClose) {
	    jQuery("#TB_closeWindowButton").click();
    }
  }

  if (window.addEventListener) { addEventListener("message", caljApiObtainListener, false); }
  else { attachEvent("onmessage", caljApiObtainListener); }


  jQuery(".button-calj-obtain-key").click(function () {
    setTimeout(function () {
      // Transaction inside the iframe is serious. Do not close the iframe inadvertently by clicking outside.
      jQuery("#TB_overlay").off();
    }, 500);
  });

  jQuery(".button-calj-clear-chache-now").click(function () {
    var $link = jQuery(this);
    jQuery.ajax({
      "type": "POST",
      "data": {
        "calj-clear-cache": 1
      },
      "success": function () {
        jQuery(".calj-ok-cache-cleared").css("visibility", "visible");
        setTimeout(function () {
          jQuery(".calj-ok-cache-cleared").css("visibility", "hidden");
        }, 5000);
      }
    });
    return false;
  });
});
</script>
ENDSCRIPT;
	}

	/**
	 * Register and add settings
	 */
	public function page_init()
	{
		register_setting(
			'my_option_group', // Option group
			CalJPlugin::CALJ_API_OPTION, // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'API', // Title
			array( $this, 'print_section_info' ), // Callback
			'calj-setting' // Page
		);

		add_settings_field(
			'api_key', // ID
			'API Key', // Title
			array( $this, 'api_key_callback' ), // Callback
			'calj-setting', // Page
			'setting_section_id' // Section
		);

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input )
	{
		return $input;
	}


	/**
	 * Get the settings option array and print one of its values
	 */
	public function api_key_callback()
	{
		printf(
			'<input type="text" size="60" id="calj_api_key" name="'.CalJPlugin::CALJ_API_OPTION.'[api_key]" value="%s" />',
			isset( $this->options['api_key'] ) ? esc_attr( $this->options['api_key']) : ''
		);
	}
}
