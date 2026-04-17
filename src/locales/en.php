<?php
namespace calj\wordpress\locales;

use calj\wordpress\locales\Locale;

class en extends Locale
{
	public function __construct() {
        parent::init('en_US');
    }

  public $strings = [
    'jmonthName' => [
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
    'parasha' => [
        "Bereshit",
        "Noach",
        "Lech Lecha",
        "Vayera",
        "Chayei Sarah",
        "Toldot",
        "Vayetze",
        "Vayishlach",
        "Vayeshev",
        "Miketz",
        "Vayigash",
        "Vayechi",
        "Shemot",
        "Va'era",
        "Bo",
        "Beshalach",
        "Yitro",
        "Mishpatim",
        "Teruma",
        "Tetzaveh",
        "Ki tissa",
        "Vayak'hel",
        "Pekudei",
        "Vayikra",
        "Tzav",
        "Shemini",
        "Tazria",
        "Metzora",
        "Acharei Mot",
        "Kedoshim",
        "Emor",
        "Behar",
        "Bechukotai",
        "Bamidbar",
        "Nasso",
        "Beha'alotcha",
        "Shelach Lecha",
        "Korach",
        "Chuqat",
        "Balak",
        "Pinchas",
        "Matot",
        "Mas'ei",
        "Devarim",
        "Vaetchanan",
        "Ekev",
        "Re'eh",
        "Shoftim",
        "Ki Tetze",
        "Ki Tavo",
        "Nitzavim",
        "Vayelech",
        "Ha'azinu",
        "Vezot Haberacha",
    ]
  ];
}
