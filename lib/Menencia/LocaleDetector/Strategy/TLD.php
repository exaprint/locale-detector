<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:42
 * To change this template use File | Settings | File Templates.
 */

namespace Menencia\LocaleDetector\Strategy;

class TLD implements IStrategy
{

    /** @var array */
    public static $locales = [
        "it" => "it-IT",
        "es" => "es-ES",
        "pt" => "pt-PT",
        "uk" => "en-GB",
        "fr" => "fr-FR",
    ];

    public function detect()
    {
        if (isset($_SERVER) && array_key_exists('SERVER_NAME', $_SERVER) && !empty($_SERVER['SERVER_NAME'])) {
            $tld = $this->_getTld($_SERVER['SERVER_NAME']);
            $locale = $this->_getLocaleFromTld($tld);
            return $locale;
        }
        return null;
    }

    protected function _getTld($serverName)
    {
        $serverName = parse_url($_SERVER['SERVER_NAME']);
        preg_match('#\.([a-z]+)$#', $serverName['path'], $matches);
        $tld = $matches[1];
        return $tld;
    }

    protected function _getLocaleFromTld($tld)
    {
        if(isset(self::$locales[$tld])){
            return collator_create(self::$locales[$tld]);
        }
        return null;
    }

}