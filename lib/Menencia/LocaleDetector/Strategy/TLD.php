<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:42
 * To change this template use File | Settings | File Templates.
 */

namespace Menencia\LocaleDetector\Strategy;

class TLD implements IStrategy {

    public function detect() {
        if (isset($_SERVER) && array_key_exists('SERVER_NAME', $_SERVER)) {
            $serverName = parse_url($_SERVER['SERVER_NAME']);
            preg_match('#\.([a-z]+)$#', $serverName, $matches);
            return $matches[1];
        } else {
            return null;
        }
    }

}