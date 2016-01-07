<?php
namespace zPetr\ApigilityXml;

use Zend\Mvc\MvcEvent;

/**
 * ZF2 module
 */
class Module
{
    /**
     * Retrieve module configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * Retrieve autoloader configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array('Zend\Loader\StandardAutoloader' => array('namespaces' => array(
            __NAMESPACE__ => __DIR__ . '/src/',
        )));
    }

    
    /**
     * Retrieve Service Manager configuration
     *
     * Defines HtmlNegotiation\HtmlStrategy service factory.
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array('factories' => array(
            'zPetr\ApigilityXml\XmlRenderer' => function ($services) {
                $helpers            = $services->get('ViewHelperManager');
                $apiProblemRenderer = $services->get('ZF\ApiProblem\ApiProblemRenderer');
                $config             = $services->get('Config');
                
                $renderer = new View\XmlRenderer($apiProblemRenderer,$config);
                $renderer->setHelperPluginManager($helpers);
                
                return $renderer;
            },
            'zPetr\ApigilityXml\XmlStrategy' => function ($services) {
                $renderer = $services->get('zPetr\ApigilityXml\XmlRenderer');
                return new View\XmlStrategy($renderer);
            },
        ));
    }

    /**
     * Listener for bootstrap event
     *
     * Attaches a render event.
     *
     * @param  \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap($e)
    {
    	$app      = $e->getTarget();
    	$services = $app->getServiceManager();
    	$events   = $app->getEventManager();
    	$events->attach(MvcEvent::EVENT_RENDER, array($this, 'onRender'), 100);
    }

    public function onRender($e)
    {
        $result = $e->getResult();
        //var_dump($result);die;
        if (!$result instanceof View\XmlModel) {
            return;
        }
        
        $app                 = $e->getTarget();
    	$services            = $app->getServiceManager();
    	$view                = $services->get('View');
    	$events              = $view->getEventManager();

        // Attach strategy, which is a listener aggregate, at high priority
        $view->getEventManager()->attach($services->get('zPetr\ApigilityXml\XmlStrategy'), 100);
    }
}
