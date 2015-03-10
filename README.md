# Communify SDK for PHP ![Build Status](http://ci.yourcommunify.com:8111/app/rest/builds/buildType:id:Master_SDK/statusIcon)

The **Communify SDK for PHP** enables PHP developers to use [Communify Web Services][communify]
in their PHP code. You can get started in
minutes by [installing the SDK through Composer][docs-installation] or by
downloading a single zip or phar file from our [latest release][latest-release].

## Features

* Single Sign On

## Getting Started

1. **Sign up for Communify**
1. **Minimum requirements**
1. **Install the SDK**
1. **Using the SDK**

## Examples

### Single Sign On

```php

    <?php 
        $ssid = 'COMMUNIFY ACCOUNT SSID';
        $data = array(
            'email'     		=> 'USER EMAIL',
            'name'      		=> 'USER NAME',
            'surname'   		=> 'USER SURNAME',
            ...
        );
        echo \Communify\S2O\S2OClient::factory()->login($ssid, $data)->metas();
    ?>

```
