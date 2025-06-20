<?php
namespace calj\wordpress;

class CalJPlugin
{
	const SHABBAT_CACHE_OPTION = 'calj_shabbat_cache';
	const CALJ_API_OPTION = 'calj_api';

	private static $shabbatCache = null;

	public function __construct() {
		add_shortcode( 'caljshabbat', array( $this, 'shortcode' ) );
	}

	public static function uninstall() {
		delete_option(self::SHABBAT_CACHE_OPTION);
		delete_option(self::CALJ_API_OPTION);
	}

	private function buildCacheKeyForCurrentSettings()
	{
        return self::getoptopt('city', '');
	}

	public function shortcode($atts)
	{
        try {
            $decodedAttr = shortcode_atts( array(
                'val' => '',
                'lang' => '',
                'city' => ''
            ), $atts );

            if (! $decodedAttr['val']) {
                throw new \Exception('Missing "val" attribute.', 2);
            }

            $result = '';

            $cache = $this->unserializeShabbatCache();
            if ( (0 == count($cache)) || ! is_array($cache) ) {
                $cache = $this->refreshCache();
            }

            if ((! $cache) || (0 == count($cache)) || ! is_array($cache)) {
                throw new \Exception('Invalid data in cache, even after refresh.', 3);
            }

            // Check if cache is fresh enough
            $coordKey = $this->buildCacheKeyForCurrentSettings();

            if (array_key_exists($coordKey, $cache)) {
                $coordCache = $cache[$coordKey];
                $expires = $coordCache['expires'];
                $dtNow = new \DateTime('now', new \DateTimeZone('UTC'));
                if ($dtNow->format('U') > $expires) {
                    $cache = $this->refreshCache($coordKey);
                }
            }
            else {
                $cache = $this->refreshCache();
            }

            if (! array_key_exists($coordKey, $cache)) {
            }
            else {
                $coordCache = $cache[$coordKey];
            }

            $json = $coordCache;

            if (isset($json['success']) && $json['success']) {

                $city = $decodedAttr['city'];
                $lang = $decodedAttr['lang'];

                // If we're demanding city-related data,
                // use the corresponding sub-part of the dictionary
                if ($city) {
                    if (array_key_exists('cities', $json) &&
                        array_key_exists($city, $json['cities'])) {
                        $json = $json['cities'][$city];
                    } else {
                        // Better explicitly indicate that no data was found,
                        // rather than silently give wrong zmanim.
                        return '-';
                    }
                }

                // dot notation to access the json properties
                $jsonPath = preg_split('#\.#', $decodedAttr['val']);
                $jsonCursor = $json;
                for($i = 0; $i < count($jsonPath); ++ $i) {
                    $component = $jsonPath[$i];

                    // If the component name exists with a 'Loc' suffix,
                    // treat it as an array of language codes
                    if ($lang &&
                        array_key_exists($component.'Loc', $jsonCursor) &&
                        is_array($jsonCursor[$component.'Loc']) &&
                        array_key_exists($lang, $jsonCursor[$component.'Loc'])
                    ) {
                        $jsonCursor = $jsonCursor[$component.'Loc'][$lang];
                    }

                    else if (array_key_exists($component, $jsonCursor)) {
                        $jsonCursor = $jsonCursor[$component];
                    }
                    else {
                        $jsonCursor = '';
                        break;
                    }
                }

                if (is_array($jsonCursor)) {
                    // If we get an array in response, it means that there are 7 items (1 per day of the week, starting Sun)
                    $dow = date('N') % 7;
                    if (array_key_exists($dow, $jsonCursor)) {
                        $result = $jsonCursor[$dow];
                    }
                    else {
                        $result = '';
                    }
                }
                else {
                    $result = $jsonCursor;
                }
            }
            return $result;
        } catch (\Exception $e) {
            return '[ERR:' . $e->getCode() . ':' . $e->getMessage() . ']';
        }
	}

	private function refreshCache($coordKey = null)
	{
        $key = self::getoptopt('api_key', '');
        if (!$key) {
            throw new \Exception('Missing API key.', 4);
        }

        $city =  self::getoptopt('city', '');
        // Fixed by idokd ( ido@yalla-ya.com ): instead of file_get_contents
        $url = 'https://api.calj.net/wp/1/shabbat.json?city='.$city.'&key='.$key;
        $response = wp_remote_get( $url );
        $response = wp_remote_retrieve_body( $response );

        $response = json_decode($response, true);
        if ( (! $response) || (! isset($response['data'])) || (! $response['data']) ) {
            throw new \Exception('API call returned no data.', 5);
        }

        $response = json_decode( self::xorString($response['data']), true );
        if ( ! $response ) {
            throw new \Exception('Failed to decrypt the response.', 6);
        }

        if (null == $coordKey) {
            $cache = array();
            $coordKey = $this->buildCacheKeyForCurrentSettings();
        }

        $cache[$coordKey] = $response;

        $this->serializeShabbatCache($cache);

        return $cache;
	}

	private function unserializeShabbatCache()
	{
		if (null !== self::$shabbatCache) {
			return self::$shabbatCache;
		}

		self::$shabbatCache = get_option(self::SHABBAT_CACHE_OPTION, array());
		return self::$shabbatCache;
	}

	private function serializeShabbatCache(array $cache)
	{
		add_option( self::SHABBAT_CACHE_OPTION, $cache, '', 'no');
		update_option( self::SHABBAT_CACHE_OPTION, $cache);
		self::$shabbatCache = $cache;
	}

	private static function xorString($text)
	{
		$key = md5(get_option('wpcjseed'));

		// Our output text
		$outText = '';

		// Iterate through each character
		for($i = 0; $i < strlen($text); )
			for($j = 0; ($j < strlen($key) && $i < strlen($text)); $j++, $i++)
				$outText .= substr($text, $i, 1) ^ substr($key, $j, 1);

		return $outText;
	}

    private static function getoptopt($optName, $default) {
        $options = get_option( self::CALJ_API_OPTION );
        if (!$options || !is_array($options) || !array_key_exists($optName, $options)) {
            return $default;
        }
        return $options[$optName];
    }
}

