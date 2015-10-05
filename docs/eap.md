![alt text][logo]
[logo]: communify-logo.png
# Using Email After Purchase (EAP) with Communify SDK

Els Email After Purchase s'hauràn d'utilitzar sempre que es vulgui portar un control de les comandes que es realitzen a 
la web. Aquests EAP crearan EAP Requests que es podran gestionar des de la comunitat de Communify.

## 1. Email After Purchase integration

Per a generar EAP Requests cal utilitzar el següent codi, per exemple:  

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
    
    $order = array($productLine1, productLine2, ...);
    
    $data = array(
        'info' => $order
    )

    \Communify\EAP\EAPClient::factory()->setOrder($accountId, $data);
    
Cal conèixer i afegir correctament els paràmetres a l'array de dades per a obtenir el resultat desitjat.

L'array `$data` estarà compost per un camp `info` que s'emplenarà amb les dades de la comanda (`order`) que estigui efectuant el client.   
L'array `$order` estarà compost per una llista d'array de `productes`.   
L'array `$producte` serà el que contindrà tota la informació de cada producte existent a una comanda. Els paràmetres d'aquest array són els següents:

**Required array fields:**

* user_email (REQUIRED)
* order_id (REQUIRED)
* product_id (REQUIRED)
* price (REQUIRED)
* title (REQUIRED)

**Optional array fields:**

* product_name
* title_to_display
* description
* category_slug
* category_name
* category_description
* site_image_url
* location_url
* user_name
* user_surname
* language_id
* user_file_url

Considerations: All product lines have same user All product lines have same order_id.

La funció `setOrder()` és la que executarà la creació de l'EAP Request, per tant, caldria cridar-la un cop la comanda 
canvii a estat "enviada" des del panell d'administració del eCommerce. 
