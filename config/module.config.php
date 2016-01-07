<?php
return array(
    'zf-content-negotiation' => array(
        'selectors'   => array(
            'HalJsonXML' => array(
                'ZF\Hal\View\HalJsonModel' => array(
                    'application/json',
                    'application/*+json',
                ),
                'zPetr\ApigilityXml\View\XmlModel' => array(
                    'application/xml',
                    'application/*+xml',
                ),
            ),
        ),
    ),
);
