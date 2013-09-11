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

    /** @var \Collator */
    protected $current;

    /** @var string */
    protected static $default = 'fr';

    /** @var array */
    protected $order = ['TLD', 'Cookie', 'Header', 'NSession', 'IP'];

    /** @var array */
    protected $_customs = [];

    public function __construct()
    {
        if (!extension_loaded('intl')) {
            throw new \Exception('The extension intl must be installed.');
        }
    }

    /**
     * @param array $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function detect()
    {
        $i = 0;
        while ($i < count($this->order) && $this->current == NULL) {
            switch ($this->order[$i]) {
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
                default:
                    if (strpos($this->order[$i], 'custom:') == 0) {
                        $name = substr($this->order[$i], 7);
                        $locale = $this->_customs[$name]();
                        $this->setLocale($locale);
                    }
                    break;
            };
            if (isset($strategy)) {
                $locale = $strategy->detect();
                if ($locale != null) {
                    $this->setLocale($locale);
                }
            }
            $i++;
        }

        if ($this->current == null) {
            $this->setLocale(collator_create(\Locale::getDefault()));
        }

        return $this->getLocale();
    }

    /**
     * @param $locale
     */
    function setLocale($locale)
    {
        $this->current = $locale;
    }

    /**
     * @return string|null
     */
    public function getLocale()
    {
        if ($this->current) {
            return collator_get_locale($this->current, \Locale::VALID_LOCALE);
        }
        return null;
    }

    /**
     * @param $name
     * @param $callback
     */
    public function registry($name, $callback)
    {
        $this->_customs[$name] = $callback;
    }

}