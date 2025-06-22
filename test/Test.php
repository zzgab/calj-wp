<?php

namespace calj\wordpress;
require_once __DIR__.'/../src/CalJPlugin.php';

$db = [
    'calj_api' => [
        'api_key' => 'sAkJaTNCx1V',
    ],
    'wpcjseed' => 'b2da79327d0ed710b0b'
];

function add_option( $k, $v, $x, $y)
{
    global $db;
    $db[$k] = $v;
}

function update_option( $k, $v)
{
    global $db;
    $db[$k] = $v;
}


function dexor($data)
{
    $method = new \ReflectionMethod('\\calj\\wordpress\\CalJPlugin::xorString');
    $method->setAccessible(true);
    return $method->invoke(null, $data);
}

$mockResponse = <<<EOF
{
  "success":true,
  "dafyomi":{
  "string":[
    "\u05e2\u05d1\u05d5\u05d3\u05d4 \u05d6\u05e8\u05d4 \u05d3",
    "\u05e2\u05d1\u05d5\u05d3\u05d4 \u05d6\u05e8\u05d4 \u05d4",
    "\u05e2\u05d1\u05d5\u05d3\u05d4 \u05d6\u05e8\u05d4 \u05d5",
    "\u05e2\u05d1\u05d5\u05d3\u05d4 \u05d6\u05e8\u05d4 \u05d6",
    "\u05e2\u05d1\u05d5\u05d3\u05d4 \u05d6\u05e8\u05d4 \u05d7",
    "\u05e2\u05d1\u05d5\u05d3\u05d4 \u05d6\u05e8\u05d4 \u05d8",
    "\u05e2\u05d1\u05d5\u05d3\u05d4 \u05d6\u05e8\u05d4 \u05d9"
    ]
  },
  "shabbat":{
    "date":"2025-06-28",
    "fridayDate":"2025-06-27",
    "day":28,
    "fridayDay":27,
    "month":6,
    "monthNameLoc":{
      "en":"June",
      "fr":"juin",
      "he":"\u05d9\u05d5\u05e0\u05d9",
      "ru":"\u0438\u044e\u043d\u044f"
    },
    "fridayMonth":6,
    "fridayMonthNameLoc":{
      "en":"June",
      "fr":"juin",
      "he":"\u05d9\u05d5\u05e0\u05d9",
      "ru":"\u0438\u044e\u043d\u044f"
    },
    "year":2025,
    "fridayYear":2025,
    "jday":2,
    "jmonthName":"Tamouz",
    "jmonthNameLoc":{
      "en":"Tammuz",
      "fr":"Tamouz",
      "he":"\u05ea\u05de\u05d5\u05d6",
      "ru":"\u0422\u0430\u043c\u0443\u0437"
    },
    "jyear":5785,
    "begins":"21:39",
    "beginsHour12":"9",
    "beginsHour24":"21",
    "beginsMinute":"39",
    "ends":"23:04",
    "endsHour12":"11",
    "endsHour24":"23",
    "endsMinute":"04",
    "parasha":"Kora\u1e25",
    "parashaLoc":{
      "en":"Korach",
      "fr":"Kora\u1e25",
      "he":"\u05e7\u05e8\u05d7",
      "ru":"\u041a\u043e\u0440\u0430\u0445"
    }
  },
  "city":{"lat":48.839,"lon":2.416,"name":"Saint-Mand\u00e9","country":"FR","tz":"Europe/Paris"},
  "cities":{
    "StMande":{
      "city":{"lat":48.839,"lon":2.416,"name":"Saint-Mand\u00e9","country":"FR","tz":"Europe/Paris"},
      "shabbat":{"date":"2025-06-28","fridayDate":"2025-06-27","day":28,"fridayDay":27,"month":6,"monthNameLoc":{"en":"June","fr":"juin","he":"\u05d9\u05d5\u05e0\u05d9","ru":"\u0438\u044e\u043d\u044f"},"fridayMonth":6,"fridayMonthNameLoc":{"en":"June","fr":"juin","he":"\u05d9\u05d5\u05e0\u05d9","ru":"\u0438\u044e\u043d\u044f"},"year":2025,"fridayYear":2025,"jday":2,"jmonthName":"Tamouz","jmonthNameLoc":{"en":"Tammuz","fr":"Tamouz","he":"\u05ea\u05de\u05d5\u05d6","ru":"\u0422\u0430\u043c\u0443\u0437"},"jyear":5785,"begins":"21:39","beginsHour12":"9","beginsHour24":"21","beginsMinute":"39","ends":"23:04","endsHour12":"11","endsHour24":"23","endsMinute":"04","parasha":"Kora\u1e25","parashaLoc":{"en":"Korach","fr":"Kora\u1e25","he":"\u05e7\u05e8\u05d7","ru":"\u041a\u043e\u0440\u0430\u0445"}}
    }
  },
  "expires":1751147999
}
EOF;


function wp_remote_get($url)
{
    global $mockResponse;
//    $res = file_get_contents($url);
    $res = ['data' => dexor(json_encode(json_decode($mockResponse,true)))];
    return json_encode($res);
}

function wp_remote_retrieve_body($r)
{
    return $r;
}

function get_option($k, $default = null)
{
    global $db;
    return $db[$k] ?? $default;
}

function shortcode_atts(array $defaults, $atts)
{
    foreach ($atts as $k => $att) {
        $defaults[$k] = $att;
    }

    return $defaults;
}

class Test
{
    public function testShortcode()
    {
        $module = new CalJPlugin();
        $result = $module->shortcode(['city' => 'StMande', 'val' => 'shabbat.monthNameLoc.ru']);
        $result = $module->shortcode(['city' => 'StMande', 'val' => 'shabbat.monthName', 'lang' =>'fr' ]);
        print_r($result);
    }
}
$test = new Test();
$test->testShortcode();
