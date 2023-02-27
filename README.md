# utility-package

## Over View of package 

* Wpmet Plugin Utility helper package for Banner , Notice , Stories and Rating.
* We made a composer package for these classes together.
* By using this Helper package we are centralizing the feature of these Classes in a package manager
  (so that any update or modifications of this functionalities globally no need to give hand or keep any dependencies on our plugins)



## Composer and making :

composer is a php dependency manager which take cares of all dependencies of projects ,
it take care of namespaces initializing and calling by mapping it in its autoload.php file we just need to specify the root dir in its jeson file call composer.json we can also configure its dependencies here and its author and package name etc. 

``composer.json  file example``

```php 
{
    "name": "wpmet/utility-package",
    "description": "Utility packages for plugin, It will be used to serve Stories, Notice , Banner and Ratings",
    "type": "library",
    "license": "GPL",
    "autoload": {
        "psr-4": {
            "Wpmet\\UtilityPackage\\": "src/"
        }
    },
    "authors": [
        {
            "name": "XpeedStudio",
            "email": "info@xpeedstudio.com"
        },
        {
            "name": "Wpmet",
            "email": "info@xpeedstudio.com"
        }
    ],
    "minimum-stability": "stable",
    "require": {
         "php": ">=7.4",
         "vendor/package": ">=1.0.1"

    },
    "require-dev": {

    }

}
```
### explanation 

* namespace "Wpmet\\UtilityPackage\\" point to the src/ folder directly by composer when it calls 
* require if any other package needed for this project.
* required-dev if any other package needed for this project for only development purpose.


## to install this package by CLI

`` composer require xs-khairul/pac04  ``

## Using feature example 

```php 

/**
			 * Show WPMET stories widget in dashboard
			 */
			\Wpmet\UtilityPackage\Stories\Stories::instance( 'elementskit-lite' )
			// ->is_test(true)
			->set_filter( $filter_string )
			->set_plugin( 'ElementsKit', 'https://wpmet.com/plugin/elementskit/' )
			->set_api_url( 'https://api.wpmet.com/public/stories/' )
			->call();


			/**
			 * Show WPMET banner (codename: jhanda)
			 */
			\Wpmet\UtilityPackage\Banner\Banner::instance( 'elementskit-lite' )
			// ->is_test(true)
			->set_filter( ltrim( $filter_string, ',' ) )
			->set_api_url( 'https://api.wpmet.com/public/jhanda' )
			->set_plugin_screens( 'edit-elementskit_template' )
			->set_plugin_screens( 'toplevel_page_elementskit' )
			->call();


```

