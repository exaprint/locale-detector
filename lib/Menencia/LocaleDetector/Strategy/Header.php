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

    public function getName() {
        return 'Header';
    }

    public function detect() {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $locale = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            if ($locale !== null) {
                return collator_create($locale);
            }
        }
        return null;
    }

}