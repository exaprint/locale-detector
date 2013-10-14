<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 28/08/13
 * Time: 16:46
 * To change this template use File | Settings | File Templates.
 */

namespace Menencia\LocaleDetector\Strategy;

class IP implements IStrategy
{

    public function getName() {
        return 'IP';
    }

    public function detect()
    {
        return null;
    }

}