<?php
namespace calj\wordpress\locales;

use calj\wordpress\locales\Locale;

class he extends Locale
{
	public function __construct() {
        parent::init('he');
    }

  public $strings = [
    'jmonthName' => [
        1 => 'ניסן',
        2 => 'אייר',
        3 => 'סיון',
        4 => 'תמוז',
        5 => 'אב',
        6 => 'אלול',
        7 => 'תשרי',
        8 => 'חשון',
        9 => 'כסלב',
        10 => 'טבת',
        11 => 'שבט',
        12 => 'אדר',
        13 => 'אדר ב',
    ],
  ];
}
