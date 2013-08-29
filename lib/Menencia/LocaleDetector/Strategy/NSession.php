<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */

namespace Menencia\LocaleDetector\Strategy;

class NSession implements IStrategy {

    public function detect() {
        return (isset($_SESSION) && array_key_exists('lang', $_SESSION)) ? locale_accept_from_http($_SESSION['lang']) : null;
    }

}