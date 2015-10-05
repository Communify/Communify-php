![alt text][logo]
[logo]: communify-logo.png
# Using Single Sign On (S2O) with Communify SDK 

Utilitzant el Single Sign On (S2O) es simplifica el login dels usuaris i es crea, automàticament, un usuari a la BBDD de la comunitat.   
Així doncs, amb el Single Sign On ben configurat, els usuaris que facin login a la web també faran login automàtic al Widget de Communify en un sol pas.

El que es necessita per a que la configuració del S2O funcioni és:

* Un usuari logat
* La URL que s'utilitza per a fer login dins del Custom Project

El codi que es necessitarà requereix de l'emplenament d'un array de dades. Aquí hi ha la relació de dades d'aquest array
que posteriorment s'explicarà com utilitzar.

**Required array fields:**

* email: `string`
* name: `string`
* surname: `string`

**Optional array fields:**

* file_url: `string` (Profile pic)
* bio: `string`
* gender: `integer`
* birth_date: `integer`
* address: `string`
* postal_code: `string`
* phone: `string`
* facebook_id: `string`
* postal_code: `integer`
 

## 1. Custom project integration

Per a una correcta integració es necessita enganxar el codi descrit més avall i emplenar-lo amb les dades de sessió que generi el 
custom project. Aquestes dades de sessió emplenaran un array per a detectar i crear un usuari a la BBDD de la comunitat de Communify.

També cal emplenar la variable **accountId** amb l'account ID trobada a l'apartat 1 del [Getting Started](/#1-get-the-account-id).

Exemple de dades per utilitzar S2O: 
``` php 
    $accountId = '[ACCOUNT ID]';
    $data = array(
        'email'             => '[USER EMAIL]',
        'name'              => '[USER NAME]',
        'surname'           => '[USER SURNAME]',
        'file_url'          => '[USER IMAGE URL]'
    );
    
    $s2o-meta =  \Communify\S2O\S2OClient::factory()->login($accountId, $data)->metas();
    
    //print $s2o-meta on <head> section
```

El que fa aquest codi és cridar a la funció **metas()** del SDK de Communify i retornar un tros d'HTML amb un llistat de `<meta>` per a que el widget 
de communify gestioni la sessió de l'usuari.

Aquestes `<meta>` caldrà ubicar-les al `<head>` del projecte.
       
La integració d'aquest codi s'haurà d'adaptar a cada projecte, ja que cada custom project tindrà els seus controladors d'autenticació propis.

---

## 2. Wordpress project integration

explicació tècnica de saber a quins fitxers cal escriure el codi.

``` php
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
            'email'             => $currentUser->user_email,
            'name'              => $currentUser->user_firstname,
            'surname'           => $currentUser->user_lastname,
            'file_url'          => getAvatarUrl($currentUser->ID)
        );
        echo \Communify\S2O\S2OClient::factory()->login($accountId, $data)->metas();
    }
```

<!-- ## 3. Shopify project integration -->


<!-- ## 4. Prestashop project integration -->


<!-- ## 5. Magento project integration -->

