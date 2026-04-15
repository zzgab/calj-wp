<?php
namespace calj\wordpress\locales;

use calj\wordpress\locales\Locale;

class ru extends Locale
{
	public function __construct() {
        parent::init('ru_RU');
    }

    public $strings = [
    'jmonthName' => [
        1 => 'Ниссан',
        2 => 'Ияр',
        3 => 'Сиван',
        4 => 'Тамуз',
        5 => 'Ав',
        6 => 'Элул',
        7 => 'Тишрей',
        8 => 'Чешван',
        9 => 'Кислев',
        10 => 'Тевет',
        11 => 'Шват',
        12 => 'Адар',
        13 => 'Адар шени',
    ],
  ];
}
