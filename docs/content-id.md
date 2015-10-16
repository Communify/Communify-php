![alt text][logo]
[logo]: communify-logo.png
# Using Content ID 

El content ID es pot utilitzar de dues formes diferents:

* Integració bàsica
* Integració des de Shopify

## 1. Integració Bàsica

Per utilitzar el content ID en una integració bàsica, cal insertar el codi del content ID a partir d'un tag meta. Aquí un exemple:

    <head>
    ...
    <meta name="content_id" content="[content-id number HERE]">
    </head>
    
## 2. Integració a Shopify

Per utilitzar el content ID en una integració a Shopify cal fer el bot des de l'onboarding de Communify.
El codi d'integració que genera Communify ja inclou les dades de content ID per a cada producte

En aquest exemple de codi, el content ID està al paràmetre `data-product-id`:

    <div id="cfy-widget-s2o-data" data-product-id="{{product.id}}" 
        {% if customer %} 
            data-customer-name="{{ customer.first_name }}" 
            data-customer-surname="{{ customer.last_name }}" 
            data-customer-email="{{ customer.email }}" 
        {% endif %}>
    </div>
    <div id="communify-widget-id" data-account-slug="sso-configurat2" data-account-id="561fb7bced396">
        <div ui-view class="communify-widget"></div>
    </div>

