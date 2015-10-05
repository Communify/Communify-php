![alt text][logo]
[logo]: communify-logo.png
# Using Search Engine Optimization (SEO) with Communify SDK 

Utilitzant el Search Engine Optimization (SEO) de Communify SDK s'obtindrà una versió en HTML del widget carregat amb el 
seu contingut (Descripció, foto, opinions/idees).   
Aquesta versió HTML estarà encapsulada dins de tags `<noscript>` per evitar que es mostri per pantalla. Només els bots 
podran accedir a la lectura d'aquest tag.

**Required array fields:**

* url: `string`
* contentId: `string`

NOTA:   
[Si hi ha els dos camps requerits a l'array de dades, sempre es generarà el codi a partir del Content ID]

**Optional array fields:**

* limit: `integer`    
* order_by: `integer` 
```
    `limit` => seteja un limit de opinions/idees generades dins de la review/conversa   
    `order_by` => seteja quin ordre tindran les opinions/idees. Es pot ordenar per 'date' o per 'votes'
```
## 1. Search Engine Optimization integration

Per a una correcta integració es necessita enganxar el codi descrit més avall i emplenar-lo amb la URL o el Content ID
del widget al fitxer php que carregui la vista de la pàgina o pàgines que volem aplicar el SEO.

També cal emplenar la variable **accountId** amb l'account ID trobada a l'apartat 1 del [Getting Started](/#1-get-the-account-id).



Example code with URL:

``` php
    $accountId = '[ACCOUNT ID]';
    $data = array(
        'url'               => 'url'
            
        'limit'             => '10',
        'order_by'          => 'date'
    );
    
    $seo-html = \Communify\SEO\SEOClient::factory()->widget($accountId, $data)->html();
    
    //print $seo-html before closing <body> tag
``` 
    
Example code with contentId:
    
``` php
    $accountId = '[ACCOUNT ID]';
    $data = array(
        'contentId'         => 'contentId'            
        
        'limit'             => '10',
        'order_by'          => 'date'
    );       
    
    $seo-html = \Communify\SEO\SEOClient::factory()->widget($accountId, $data)->html();
        
    //print $seo-html before closing <body> tag
```
       
---