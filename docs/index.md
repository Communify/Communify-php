![alt text][logo]
[logo]: communify-logo.png

# Getting started with Communify SDK 

`INTRODUCTION TEXT TODO` 

### Index

1. **General Steps**
    1. Get the Account ID
    2. Install the SDK
    3. Integrate the widget

2. **[Install Single Sign On (S2O)](/s2o/)**
    1. S2O on web project
    2. S2O on Wordpress
3. **[Install Search Engine Optimization (SEO)](/seo/)**
    1. SEO integration
4. **[Install Email After Purchase (EAP)](/eap/)**
    1. EAP integration
5. **[Custom CSS](/custom-css/)**
6. **[Content ID](/content-id/)**
    1. Basic integration
    2. Shopify integration

---

### Features

* Single Sign On (`S2O`)
* Search Engine Optimization (`SEO`)
* Email After Purchase (`EAP`)

### Minimum requirements

* [PHP](http://www.php.net) version -- `5.3.0` 
* [Guzzle](https://github.com/guzzle/guzzle) version -- `3.7`
* [Mustache](https://mustache.github.io/) version -- `2.5`

---

## 1. Get the Account ID


Els primers passos a realitzar per a obtenir una bona integració del SDK de Communify és saber quina és la teva **Account ID**.
Per a trobar-la cal fer login at your Communify community and go to Settings/Integration to get your **Account ID**.
  
You will find some integration code like this.

    <div id="communify-widget-id" data-account-slug="[ACCOUNT SLUG]" data-account-id="[ACCOUNT ID]"><div ui-view class="communify-widget"></div></div>
    
Cal que es detecti el tag 'data-account-id' i el valor d'aquest serà l'**account ID** que es busca.

---

## 2. Install the SDK

`install introduction to do`

#### 1. Install Communify SDK using Composer

You need to edit composer.json. You can find it on your project folder.   
Once you can edit the file, you will add this line in "require" parameters:
    
    "communify/communify-php": "dev-master",

If you don't have any "require" parameters; you can copy and paste this example:
    
    "require": {
        "communify/communify-php": "dev-master",
    }


Execute composer update via console to save all changes.

#### 2. Install Communify SDK without using Composer

[Download SDK](https://s3-us-west-2.amazonaws.com/communify-ops/releases/master/communify_sdk.zip) and add **sdk** folder at your project.   
Then, include autload.php via PHP to use Communify SDK at the files that need to connect with Communify SDK.

---

## 3. Integrate the widget

You need to paste this code to integrate the widget into the web project:

    <div id="communify-widget-id" data-account-slug="[ACCOUNT-SLUG]" data-account-id="[ACCOUNT-ID]"><div ui-view class="communify-widget"></div></div>
    
If you want to integrate the widget with **Content ID**, you need to add this code at `head`: 
    
    <meta name="content_id" content="[CONTENT-ID]">

