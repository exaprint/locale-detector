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

    public static $fieldName = 'lang';

    public function detect() {
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION[self::$fieldName]) && !empty($_SESSION[self::$fieldName])) {
            return new \Locale($_SESSION[self::$fieldName]);
        }
        return null;
    }

}