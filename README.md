# Communify SDK for PHP

The **Communify SDK for PHP** enables PHP developers to use [Communify Web Services][communify]
in their PHP code. You can get started in
minutes by [installing the SDK through Composer][docs-installation] or by
downloading a single zip or phar file from our [latest release][latest-release].

## Features

* Single Sign On

## Getting Started

1. **Sign up for Communify**
1. **Minimum requirements** – To run the SDK, your system will need to meet the
   [minimum requirements][docs-requirements], including having **PHP 5.3.3+**
   compiled with the cURL extension and cURL 7.16.2+ compiled with OpenSSL and
   zlib.
1. **Install the SDK** – Using [Composer] is the recommended way to install the
   Communify SDK for PHP. The SDK is available via [Packagist] under the
   [`communify/communify-php`][install-packagist] package. Please see the
   [Installation section of the User Guide][docs-installation] for more
   detailed information about installing the SDK through Composer and other
   means.
1. **Using the SDK** – The best way to become familiar with how to use the SDK
   is to read the [User Guide][docs-guide]. The
   [Getting Started Guide][docs-quickstart] will help you become familiar with
   the basic concepts, and there are also specific guides for each of the
   [supported services][docs-services].

## Single Sign On

```php

    <?php 
        $data = array(
            'name'      => '...',
            'surname'   => '...',
            'email'     => '...',
            'image'     => '...',
            ...
        );    
        Communify\S2O\S2OClient::factory()->login($data)->metas();
    ?>

```
