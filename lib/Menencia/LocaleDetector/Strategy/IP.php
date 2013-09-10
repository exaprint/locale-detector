<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */

namespace Menencia\LocaleDetector\Strategy;

class IP implements IStrategy {

    public function detect() {
        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
            $content = file_get_contents('http://geoiplookup.net/geoapi.php?output=json&ipaddress='.$_SERVER['REMOTE_ADDR']);
            $json = json_decode($content, true);
            return collator_create($json['countryCode']);
        }
        return null;
    }

}