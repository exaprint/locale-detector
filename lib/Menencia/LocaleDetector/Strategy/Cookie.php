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

    public static $fieldName = 'lang';

    public function detect() {
        if (isset($_COOKIE[self::$fieldName]) && !empty($_COOKIE[self::$fieldName])) {
            return collator_create($_COOKIE[self::$fieldName]);
        }
        return null;
    }

}