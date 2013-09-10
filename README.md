To call this module :
```php
$localeDetector = new Menencia\LocaleDetector\LocaleDetector();
#$localeDetector->setOrder(...);
$localeDetector->detect();
$locale = $localeDetector->getLocale();
```