Getting started with SMSBundle
=============

[SMS]

## Prerequisites

This version of the bundle requires Symfony 2.1+ and Doctrine ORM 2.2+

## Installation

Installation is a quick 3 step process:

1. Download KarserSMSBundle using composer
2. Enable the Bundle
3. Configure the KarserSMSBundle

### Step 1: Download KarserSMSBundle using composer

Add KarserSMSBundle in your composer.json:

```js
{
    "require": {
        "karser/mainsms-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php ./composer.phar update
```

Composer will install the bundle to your project's `vendor/karser` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Karser\SMSBundle\KarserSMSBundle(),
    );
}
```

### Step 3: Configure the KarserSMSBundle

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
karser_sms:
    sms_task_class: Acme\SMSBundle\Entity\SmsTask
```

If you going to store messages in the database, don't forget to update your schema:
```
app/console doctrine:schema:update
```

### Usage Steps
@TODO