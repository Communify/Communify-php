# Communify SDK for PHP ![Build Status](http://ci.yourcommunify.com:8111/app/rest/builds/buildType:id:Master_SDK/statusIcon)

The **Communify SDK for PHP** enables PHP developers to use [Communify Web Services][communify]
in their PHP code. You can get started in
minutes by [installing the SDK through Composer][docs-installation] or by
downloading a single zip or phar file from our [latest release][latest-release].

## 1. Features

* Single Sign On (S2O)
* Search Engine Optimization (SEO)

## 2. Getting Started

1. **Sign up for Communify**
2. **Minimum requirements**
3. **Install the SDK**

### 2.1. Sign up for Communify
Go to http://communify.com, create your account, and enable Single Sign On login at Membership preferences.

### 2.2. Minimum requirements
* PHP version: >= 5.3.0
* Guzzle: 3.7
* Mustache: 2.5

### 2.3. Install the SDK
#### 2.3.1. Using composer
Modify composer.json:
````
{
    "require": {
        "communify/communify-php": "dev-master",
    }
}
```
Execute composer update.

#### 2.3.2. Without using composer
Download SDK: https://s3-us-west-2.amazonaws.com/communify-ops/releases/master/communify_sdk.zip.
Add communify_sdk folder at project, and include autload.php to use Communify SDK.

## 3. Examples

### 3.1. Single Sign On (S2O)

```php

    $ssid = '[COMMUNIFY ACCOUNT SSID]';
    $data = array(
        'communify_url' 	=> 'http://[ENV NAME].yourcommunify.com/api/[ENV NAME]',
        'email'     		=> '[USER EMAIL]',
        'name'      		=> '[USER NAME]',
        'surname'   		=> '[USER SURNAME]',
        'file_url'          => '[USER IMAGE URL]',
        'language_id'       => '[LANG ID]'
    );
    echo \Communify\S2O\S2OClient::factory()->login($ssid, $data)->metas();

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
    $ssid = '[COMMUNIFY ACCOUNT SSID]';
    if($currentUser->ID != 0)
    {
        $data = array(
            'communify_url' 	=> 'http://[ENV NAME].yourcommunify.com/api/[ENV NAME]',
            'email'     		=> $currentUser->user_email,
            'name'      		=> $currentUser->user_firstname,
            'surname'   		=> $currentUser->user_lastname,
            'file_url'          => getAvatarUrl($currentUser->ID)
        );
        echo \Communify\S2O\S2OClient::factory()->login($ssid, $data)->metas();
    }

```

### 3.2. Search Engine Optimization (SEO)

```php

    $ssid = '[COMMUNIFY ACCOUNT SSID]';
    $data = array(
        'communify_url' 	=> 'http://[ENV NAME].yourcommunify.com/api/[ENV NAME]',
        'limit'             => '10',
        'order_by'          => 'date'
    );
    
    echo \Communify\SEO\SEOClient::factory()->widget($ssid, $data)->html();

```