apigility-xmlnegotiation
=========================

XML negotiation module for Apigility

----------

This module is inspired from [abandoned ApigilityXml project][source]. Thank you to [Markus][source_dev]!
[source]: https://github.com/cloud-solutions/ApigilityXml
[source_dev]: https://github.com/markushausammann

----------

Necessary infrastructure to handle XML with ZF Apigility with HAL structure.

Response type is based on *Accept* header :

- request that specifies **application/xml** (or **application/\*+xml**) get the content in XML
- **application/hal+json** (or **application/\*+json**) request get the content in HalJson as usual. 

### Installation
Install composer in your project

    curl -s http://getcomposer.org/installer | php

Define dependencies in your composer.json file

```json
{
    "require": {
        "zpetr/apigility-xmlnegotiation" : "dev-master"
    }
}
```

Finally install dependencies

    php composer.phar install

or update it

    php composer.phar update

### Usage
- Add *zPetr\ApigilityXml* to modules.config.php:
```php
	return array(
    	...,
        'zPetr\ApigilityXml',
        ....
	)     
```
- Go to admin, select your API and change *Content Negotiation Selector* to **HalJsonXML**
- Add **application/xml** to *Accept whitelist* and *Content-Type whitelist*. Add other headers if needed.
- Save configuration