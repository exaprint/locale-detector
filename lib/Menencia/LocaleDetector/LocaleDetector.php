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
use Menencia\LocaleDetector\Strategy\IP;
use Menencia\LocaleDetector\Strategy\IStrategy;
use Menencia\LocaleDetector\Strategy\TLD;
use Menencia\LocaleDetector\Strategy\NSession;

class LocaleDetector
{

    /** @var \Collator */
    public static $current;

    /** @var array */
    protected $_order = [];

    /** @var array */
    protected $_strategies = [];

    public function __construct()
    {
        if (!extension_loaded('intl')) {
            throw new \Exception('The extension intl must be installed.');
        }

        $this->registerStrategy(new TLD());
        $this->registerStrategy(new Cookie());
        $this->registerStrategy(new Header());
        $this->registerStrategy(new NSession());
        //$this->registerStrategy(new IP());

        $this->setOrder(['TLD', 'Cookie', 'Header', 'NSession']);
    }

    /**
     * @return null|string
     */
    public function detect()
    {
        $i = 0;
        while ($i < count($this->_order) && self::$current == NULL) {

            $strategy = $this->_order[$i];

            $locale = $this->_strategies[$strategy];

            $this->setLocale($locale);

            $i++;
        }

        if (self::$current == NULL) {
            $this->setLocale(collator_create(\Locale::getDefault()));
        }

        return $this->getLocale();
    }

    /**
     * @param $name
     * @param $callback
     * @param $args
     */
    public function addCallback($name, $callback, $args) {
        $this->_strategies[$name] = call_user_func_array($callback, $args);
    }

    /**
     * @param IStrategy $strategy
     */
    public function registerStrategy(IStrategy $strategy) {
        $this->_strategies[$strategy->getName()] = $strategy->detect();
    }

    /**
     * @param array $order
     */
    public function setOrder($order)
    {
        $this->_order = $order;
    }

    /**
     * @param $locale
     */
    function setLocale($locale)
    {
        self::$current = $locale;
    }

    /**
     * @return string|null
     */
    public function getLocale()
    {
        if (self::$current) {
            return collator_get_locale(self::$current, \Locale::VALID_LOCALE);
        }
        return null;
    }

}