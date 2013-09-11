# Locale-Detector package

Using this module, you can then get the locale detected for the user, based on what you want first.

To call this module :

```php
$localeDetector = new Menencia\LocaleDetector\LocaleDetector();
```

This is the actual strategy order, but you can reorder this array or remove some items :

```php
$localeDetector->setOrder(['TLD', 'Cookie', 'Header', 'NSession', 'IP']); // optional
```

* TLD (Top-level domain): determining locale from `$_SERVER['SERVER_NAME']`
* Cookie: determining locale from `$_COOKIE[$field]`
* Header: determining locale from `$_SERVER['HTTP_ACCEPT_LANGUAGE']`
* NSession (Session): determining locale from `$_SESSION[$field]`
* IP (IP Address): determining locale from `$_SERVER['REMOTE_ADDR']`
* By default, determining locale from `Locale::getDefault()`

By default, `$field = 'lang';`. This is how you can change that :

```php
Cookie::$fieldName = 'newlang';
NSession::$fieldName = 'newlang';
```

Then, you just have to call the detect method and retrieve the locale :

```php
$locale = $localeDetector->detect();
```

## Advanced strategies

You have the possibility to custom your strategy like this :

```php
$localeDetector->register('OtherStrategy', function($a){
    return collator_create($a);
}, ['fr-FR']);

$localeDetector->setOrder(['callback:OtherStrategy']);

$locale = $localeDetector->detect();
```

Maybe you want to extends the Strategy interface :

```php
$localeDetector->setOrder(['custom:Path\To\NewStrategy']);

$locale = $localeDetector->detect();
```

And your new Strategy should be like that :

```php
namespace Path\To\NewStrategy;

class New Strategy implements Menencia\LocaleDetector\Strategy\IStrategy
{

    public function detect()
    {
        return collator_create('fr-FR');
    }

}
```