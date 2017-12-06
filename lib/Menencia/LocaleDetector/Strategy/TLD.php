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

    public function getName() {
        return 'TLD';
    }

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
        if (!isset($_SERVER)) {
            return null;
        }
        foreach (array('SERVER_NAME', 'HTTP_HOST') as $serverKey) {
            if (!array_key_exists($serverKey, $_SERVER) || empty($_SERVER[$serverKey])) {
                continue;
            }
            if (!$tld = $this->_getTld($_SERVER[$serverKey])) {
                continue;
            }
            return $this->_getLocaleFromTld($tld);
        }
        return null;
    }

    protected function _getTld($url)
    {
        $parsedUrl = parse_url($url);
        preg_match('#\.([a-z]+)$#', $parsedUrl['path'], $matches);
        return count($matches) ? $matches[1] : false;
    }

    protected function _getLocaleFromTld($tld)
    {
        if(isset(self::$locales[$tld])){
            return collator_create(self::$locales[$tld]);
        }
        return null;
    }

}