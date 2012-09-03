ContentBundle
==========

Introduction
------------

This bundle provides basic CMS functionality with its own admin part. It didn't require any other bundles.

**IMPORTANT** This bundle is in development.

Features
------------

* Categories management (frontend + backend).
* Content management (frontend + backend).
* Bundle is translated, see Resources/translations.

Requirements
------------

* Symfony2 with twig.
* Doctrine2, DoctrineExtension & DoctrineFixtures.
* Highly recommended [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) (please see the installation steps [here](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md)).
* Annotations for Controllers.
* jQuery + twitter bootstrap js.
* Twitter Bootstrap css file (or with the same styles).
* It is recommended to use this bundle with [SmirikAdminBundle](https://github.com/smirik/SmirikAdminBundle) which provides public assets (including twitter bootstrap & jquery) + menu + core classes.

Installation
------------

* Add bundle to your `deps` file:

  ```
  [SmirikContentBundle]
    git=git://github.com/smirik/SmirikContentBundle.git
    target=/bundles/Smirik/ContentBundle
  ```

* Register the namespace in `autoload.php` (if you don't use other Smirik* bundles):

  ```
  $loader->registerNamespaces(array(
      ...
      'Smirik'           => __DIR__.'/../vendor/bundles',
  ));
  ```

* Register bundle in your `AppKernel.php`:

  ```
  $bundles = array(
      ...
      new Smirik\ContentBundle\SmirikContentBundle(),
      ...
  );
  ```

* Add routes to `routing.yml`:

 ```
  SmirikContentBundle:
      resource: "@SmirikContentBundle/Controller/"
      type:     annotation
      prefix:   /
  ```
* Update database and load test fixtures to see admin functionality

  ```
  php app/console doctrine:schema:update --force
  php app/console doctrine:fixtures:load --append
  ```

* See test content at `http://host/admin/content/`

* Please check that `bootstrap.css` file is loaded. 
    
* Enjoy!


Database schema
---------------

License
-------

Academic.
