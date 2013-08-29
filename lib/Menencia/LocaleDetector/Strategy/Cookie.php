<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */

namespace Menencia\LocaleDetector\Strategy;

class Cookie implements IStrategy {

    public function detect() {
        return (isset($_COOKIE) && array_key_exists('lang', $_COOKIE)) ? $_COOKIE['lang']: null;
    }

}