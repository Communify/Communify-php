![alt text][logo]
[logo]: communify-logo.png
# Custom CSS introduction
 
Generar Custom CSS pels widgets de Communify és senzill. Cal entrar al backoffice de la teva comunitat i accedir a **Apearance -> Custom CSS**.   
En aquesta pantalla ens trobarem dues pestanyes:

* Floating widget
* Embedded widget

Només cal carregant el codi CSS que es vulgui personalitzar i guardar els canvis.   
El CSS que es genera manarà per sobre del fitxer CSS bàsics creats pels desenvolupadors de Communify.

## Basic Custom CSS

Entenem com a Basic Custom CSS tot aquell codi CSS personalitzat que ataca a les classes genèriques de Communify.   
Aquests canvis s'aplicaràn a totes les converses i reviews per igual.

## Content ID a Custom CSS 

Entenem com a Content ID a Custom CSS tot aquell codi CSS personalitzat que ataca a una única conversa o review, gràcies al Content ID.   
Aquests canvis s'aplicaràn únicament al widget que porti assignat el Content ID incrustat al CSS.

Per utilitzar Content ID a Custom CSS a la **pill** cal canviar la classe: 
    
    .cfy-widget-pill
    
Per la classe:

    .cfy-widget-pill-content-id-1122332211
    
On `1122332211` és el content ID d'exemple

Per utilitzar Content ID a Custom CSS al **container** cal canviar la classe: 
    
    .cfy-widget-content
        
Per la classe:

    .cfy-widget-content-id-1122332211
        
On `1122332211` és el content ID d'exemple



