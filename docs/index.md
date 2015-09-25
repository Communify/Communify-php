# Communify SDK for PHP ![Build Status](http://ci.yourcommunify.com:8111/app/rest/builds/buildType:id:Master_SDK/statusIcon)

The **Communify SDK for PHP** enables PHP developers to use [Communify Web Services][communify]
in their PHP code. You can get started in
minutes by [installing the SDK through Composer][docs-installation] or by
downloading a single zip or phar file from our [latest release][latest-release].

## 1. Features

* Single Sign On (S2O)
* Search Engine Optimization (SEO)
* Email After Purchase (EAP)

## 2. Getting Started

1. **Sign up for Communify**
2. **Minimum requirements**
3. **Get your AccountId**
3. **Install the SDK**

### 2.1. Sign up for Communify
Go to http://communify.com, create your account, and enable Single Sign On login at Membership preferences. To enable single sign on go to Settings/Membership.

### 2.2. Get your Account Id 
Go to settings/Integration to get it:
```html
<di id="communify-widget-id" data-account-slug="[ACCOUNT SLUG]" data-account-id="[ACCOUNT ID]"><div ui-view class="communify-widget"></div></div>
```

### 2.3. Minimum requirements
* PHP version: >= 5.3.0
* Guzzle: 3.7
* Mustache: 2.5

### 2.4. Install the SDK
#### 2.4.1. Using composer
Modify composer.json:
```
{
    "require": {
        "communify/communify-php": "dev-master",
    }
}
```
Execute composer update.

#### 2.4.2. Without using composer
Download SDK: https://s3-us-west-2.amazonaws.com/communify-ops/releases/master/communify_sdk.zip. Add communify_sdk folder at project, and include autload.php to use Communify SDK.

## 3. Examples

### 3.1. Single Sign On (S2O)
Use this code. Metas have to been rendered at <head></head> tag.

```php

    $accountId = '[ACCOUNT ID]';
    $data = array(
        'email'     		=> '[USER EMAIL]',
        'name'      		=> '[USER NAME]',
        'surname'   		=> '[USER SURNAME]',
        'file_url'          => '[USER IMAGE URL]',
        'language_id'       => '[LANG ID]'
    );
    echo \Communify\S2O\S2OClient::factory()->login($accountId, $data)->metas();

```

#### 3.1.1. Single Sign On (S2O) and Wordpress

```php

    function getAvatarUrl($id)
    {
        $avatar = get_avatar($id);
	    preg_match("/src=\"(.*?)\"/i", $avatar, $matches);
    	$url = $matches[1];
	    $urlArray = parse_url($url);
	    return 'http://'.$urlArray['host'].$urlArray['path'];
    }

    $currentUser = wp_get_current_user();
    $accountId = '[ACCOUNT ID]';
    if($currentUser->ID != 0)
    {
        $data = array(
            'email'     		=> $currentUser->user_email,
            'name'      		=> $currentUser->user_firstname,
            'surname'   		=> $currentUser->user_lastname,
            'file_url'          => getAvatarUrl($currentUser->ID)
        );
        echo \Communify\S2O\S2OClient::factory()->login($accountId, $data)->metas();
    }

```

### 3.2. Search Engine Optimization (SEO)

```php

    $accountId = '[ACCOUNT ID]';
    $data = array(
        'limit'             => '10',
        'order_by'          => 'date'
    );
    
    echo \Communify\SEO\SEOClient::factory()->widget($accountId, $data)->html();

```

### 3.3. Email After Purchase (EAP)
Considerations:
* All product lines have same user
* All product lines have same order_id
* Some product line fields are mandatories: orderId, price, productId, userEmail.

```php

    $accountId = '[ACCOUNT ID]';
    $productLine1 = array(
        'order_id'              => [ORDER ID],
        'price'                 => [PRICE],
        'product_id'            => [PRODUCT/TOPIC ID],
        'product_name'          => [PRODUCT/TOPIC NAME],
        'title'                 => [PRODUCT/TOPIC TITLE],
        'location_url'          => [PRODUCT/TOPIC URL]
        'title_to_display'      => [PRODUCT/TOPIC TITLE TO DISPLAY],
        'description'           => [PRODUCT/TOPIC DESCRIPTION],
        'site_image_url'        => [PRODUCT/TOPIC IMAGE URL],
        'category_slug'         => [CATEGORY SLUG],
        'category_name'         => [CATEGORY NAME],
        'category_description'  => [CATEGORY DESCRIPTION],
        'user_name'             => [CUSTOMER NAME],
        'user_surname'          => [CUSTOMER SURNAME],
        'user_email'            => [CUSTOMER EMAIL],            
    );
    $order = array($productLine1, [$productLine2, ...]);
    
    \Communify\EAP\EAPClient::factory()->setOrder($accountId, $order);

```
