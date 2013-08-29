<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:05
 * To change this template use File | Settings | File Templates.
 *
 * To call this module :
 *
 * $localeDetector = new Menencia\LocaleDetector\LocaleDetector();
 * $localeDetector->setOrder(...);
 * $localeDetector->detect();
 * $locale = $localeDetector->getLocale();
 *
 */

namespace Menencia\LocaleDetector;

use Menencia\LocaleDetector\Strategy\Cookie;
use Menencia\LocaleDetector\Strategy\Header;
use Menencia\LocaleDetector\Strategy\TLD;
use Menencia\LocaleDetector\Strategy\NSession;

class LocaleDetector
{

    /** @var string */
    protected $current;

    /** @var string */
    protected static $default = 'fr';

    /** @var array */
    public static $locales = [
        "it" => "it_IT",
        "es" => "es_ES",
        "pt" => "pt_PT",
        "uk" => "en_GB",
        "fr" => "fr_FR",
    ];

    /** @var array */
    protected $order = ['TLD', 'Cookie', 'Header', 'NSession'];

    /**
     * @param array $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function detect()
    {
        $i = 0;
        while ($i < count($this->order) && $this->current == null) {
            switch (self::$this->order[$i]) {
                case 'TLD':
                    $strategy = new TLD();
                    break;
                case 'Cookie':
                    $strategy = new Cookie();
                    break;
                case 'Header':
                    $strategy = new Header();
                    break;
                case 'NSession':
                    $strategy = new NSession();
                    break;
            };
            $locale = $strategy->detect();
            if ($locale != null) {
                $this->setLocale($locale);
            }
            $i++;
        }

        if ($this->current == null) {
            $this->setLocale(locale_get_default());
        }
    }

    function setLocale($locale)
    {
        if (in_array($locale, self::$locales)) {
            $locale = self::$locales[$locale];
        } else if (!array_key_exists($locale, self::$locales)) {
            $locale = 'fr';
        }

        $this->current = $locale;

        #putenv("LC_MESSAGES=" . $this->current);
        #setlocale(LC_MESSAGES, $this->current);
        #if (function_exists('bindtextdomain') && function_exists('textdomain')) {
        #    bindtextdomain("messages", APPLICATION_ROOT . "/locale");
        #    textdomain("messages");
        #    bind_textdomain_codeset("messages", "UTF-8");
        #}
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return self::$locales[$this->current];
    }

}