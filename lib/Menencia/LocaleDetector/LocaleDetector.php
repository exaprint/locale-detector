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
    protected $order = ['TLD', 'Cookie', 'Header', 'NSession'];

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

    public function detect()
    {
        $i = 0;
        while ($i < count($this->order) && $this->current == null) {
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
            };
            $locale = $strategy->detect();
            if ($locale != null) {
                $this->setLocale($locale);
            }
            $i++;
        }

        if ($this->current == null) {
            $this->setLocale(\Locale::getDefault());
        }
    }

    function setLocale($locale)
    {
        $this->current = $locale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return self::$locales[$this->current];
    }

}