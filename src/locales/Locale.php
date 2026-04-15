<?php
namespace calj\wordpress\locales;

abstract class Locale
{
    protected function init($locale) {
        $formatter = new \IntlDateFormatter($locale, 
            \IntlDateFormatter::NONE, 
            \IntlDateFormatter::NONE, 
            null, 
            null, 
            'MMMM'
        );

        $this->strings['monthName'] = [];

        for ($i = 1; $i <= 12; ++ $i) {
            $this->strings['monthName'][$i] = 
                $formatter->format(\DateTime::createFromFormat('!m', $i));
        }
    }

}
