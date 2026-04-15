<?php
namespace calj\wordpress\locales;

use calj\wordpress\locales\Locale;

class en extends Locale
{
	public function __construct() {
        parent::init('en_US');
    }

  public $strings = [
    'jmonthName' = [
        1 => 'Nissan',
        2 => 'Iyar',
        3 => 'Sivan',
        4 => 'Tamuz',
        5 => 'Av',
        6 => 'Ellul',
        7 => 'Tishrei',
        8 => 'Cheshvan',
        9 => 'Kislev',
        10 => 'Tevet',
        11 => 'Shvat',
        12 => 'Adar',
        13 => 'Adar Bet',
    ],
  ];
}
