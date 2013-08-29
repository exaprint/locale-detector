<?php

use Menencia\LocaleDetector\LocaleDetector;

/**
 * Created by JetBrains PhpStorm.
 * User: lucien
 * Date: 29/08/13
 * Time: 09:32
 * To change this template use File | Settings | File Templates.
 */

class Test extends PHPUnit_Framework_TestCase
{

    public function testHeader()
    {
        $header = new Menencia\LocaleDetector\Strategy\Header();
        $locale = $header->detect();
        if ($locale) {
            $this->assertArrayHasKey($locale, LocaleDetector::$locales);
        } else {
            $this->assertNull($locale);
        }
    }

    public function testCookie()
    {
        $cookie = new Menencia\LocaleDetector\Strategy\Cookie();
        $locale = $cookie->detect();
        if ($locale) {
            $this->assertArrayHasKey($locale, LocaleDetector::$locales);
        } else {
            $this->assertNull($locale);
        }
    }

    public function testTLD()
    {
        $tld = new Menencia\LocaleDetector\Strategy\TLD();
        $locale = $tld->detect();
        if ($locale) {
            $this->assertArrayHasKey($locale, LocaleDetector::$locales);
        } else {
            $this->assertNull($locale);
        }
    }

    public function testSession()
    {
        $session = new Menencia\LocaleDetector\Strategy\NSession();
        $locale = $session->detect();
        if ($locale) {
            $this->assertArrayHasKey($locale, LocaleDetector::$locales);
        } else {
            $this->assertNull($locale);
        }
    }

    public function testDetectLocale()
    {
        $dl = new Menencia\LocaleDetector\LocaleDetector();
        $dl->detect();
        $this->assertContains($dl->getLocale(), LocaleDetector::$locales);
    }

    public function testParseUrl() {
        $url = 'http://genpdf.exaprint.local.fr';
        $needles = parse_url($url);
        preg_match('#\.([a-z]+)$#', $needles['host'], $matches);
        $this->assertArrayHasKey($matches[1], LocaleDetector::$locales);
    }

}
