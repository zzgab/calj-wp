=== CalJ ===
Contributors: calj
Donate link: https://www.calj.net/
Tags: calendar, date, events, hebrew, jewish, shortcode
Requires at least: 4.9
Tested up to: 6.6.2
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display the Shabbat times (zmanim) for the city of your choice.

== Description ==

Use the popular CalJ API to display the begin and end times of Shabbat as well as the name of the week's Parasha on your blog,
with the help of a simple *shortcode*

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/calj` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->CalJ screen to configure the plugin
1. Register for a free API key for your current WordPress instance inside the Settings Form

/!\ NOTE: you must install the plugin on your target (final/production) WordPress instance (Website URL)
for the registered key to work. If you register a key for a test/staging website URL, the key will
only work for that Referrer. You may register several keys if you need more than one environment.

== Frequently Asked Questions ==

= How to use the shortcode =

The `caljshabbat` shortcode accepts several directives, which you can arrange the way you want in your pages.


Print the name of the current week's Parasha.
Available languages are: `en`, `fr`, `he`, `ru`.

  `[caljshabbat val="shabbat.parasha" lang="he"]`


Print the candle-lighting time for the forthcoming Shabbat, in 24-hour format (example: `18:41`).

  `[caljshabbat val="shabbat.begins"]`


Print the hour of candle-lighting time, in 12-hour format (example: `6`).

  `[caljshabbat val="shabbat.beginsHour12"]`


Print the hour of candle-lighting time, in 24-hour format (example: `18`).

  `[caljshabbat val="shabbat.beginsHour24"]`


Print the minute of candle-lighting time (example: `41`).

  `[caljshabbat val="shabbat.beginsMinute"]`


Print the end of shabbat, in 24-hour format.
Note that you can use `endsHour12`, `endsHour24` and `endsMinute` too.

  `[caljshabbat val="shabbat.ends"]`


Print the day of month (secular) of Shabbat.

  `[caljshabbat val="shabbat.day"]`


Prints the month number (secular) of Shabbat.

  `[caljshabbat val="shabbat.month"]`


Print the name of the secular month of Saturday, in specified language (example: août).

  `[caljshabbat val="shabbat.monthName" lang="fr"]`


Print the year (secular) of Shabbat.

  `[caljshabbat val="shabbat.year"]`


Print the day of month (secular) of Friday.

  `[caljshabbat val="shabbat.fridayDay"]`


Print the month number (secular) of Friday.

  `[caljshabbat val="shabbat.fridayMonth"]`


Print the name of the secular month of Friday, in specified language (example: July).

  `[caljshabbat val="shabbat.fridayMonthName" lang="en"]`


Print the year (secular) of Friday.

  `[caljshabbat val="shabbat.fridayYear"]`


Print the day of month (Jewish) of Shabbat.

  `[caljshabbat val="shabbat.jday"]`


Print the name of the Jewish month of Shabbat.

  `[caljshabbat val="shabbat.jmonthName"]`


Print the name of the Jewish month of Shabbat in specified language.

  `[caljshabbat val="shabbat.jmonthName" lang="ru"]`


Print the Jewish year of Shabbat.

  `[caljshabbat val="shabbat.jyear"]`


Print the Daf Yomi of the current day.

  `[caljshabbat val="dafyomi.string"]`


= With multiple cities =

If you purchased a multiple-city package, you may use the following syntax to display the times for a selected city by its code:

  `[caljshabbat city="Montreal" val="shabbat.begins"]`


= How are the times calculated =

Check out https://www.calj.net/ for details.


== Changelog ==

= 1.5 =
Fix by @idokd for wp_remote_get

= 1.4.2 =
Better error handling

= 1.4.1 =
Support for PHP 8 -- fixup

= 1.4 =
Support for PHP 8

= 1.3 =
Support for multiple cities.

= 1.2.1 =
Secular month names.
Date elements for the upcoming Friday.

= 1.2 =
Support for additional languages.

= 1.1 =
Added Daf Yomi.

= 1.0 =
First release.

== Upgrade Notice ==

Just upgrade the plugin to the latest version.

== Screenshots ==

