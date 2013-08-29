<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */

namespace Menencia\LocaleDetector\Strategy;

class Header implements IStrategy {

    public function detect() {
        return (isset($_SERVER) && array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)) ? locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']) : null;
    }

}