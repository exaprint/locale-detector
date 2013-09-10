# Locale-Detector package

Using this module, you can then get the locale detected for the user, based on what you want first.

To call this module :

```php
$localeDetector = new Menencia\LocaleDetector\LocaleDetector();
```

This is the actual strategy order, but you can reorder this array or remove some items :

```php
$localeDetector->setOrder(['TLD', 'Cookie', 'Header', 'NSession']); // optional
```

Then, you just have to call the detect method and retrieve the locale :

```php
$locale = $localeDetector->detect();
```