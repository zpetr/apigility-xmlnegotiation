<?php

namespace zPetr\ApigilityXml\View;

use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Exception;

use Zend\View\HelperPluginManager;
use ZF\Hal\Plugin\Hal as HalHelper;
use ZF\ApiProblem\View\ApiProblemRenderer;

/**
 * Class XmlRenderer
 * @package zPetr\ApigilityXml\View\Renderer
 */
class XmlRenderer implements RendererInterface
{
    /**
     * @var ApiProblemRenderer
     */
    protected $apiProblemRenderer;

    /**
     * @var HelperPluginManager
     */
    protected $helpers;

    /**
     * @var ViewEvent
     */
    protected $viewEvent;
    
    /**
     * @var Config
     */
    protected $config;
    
    private $_entity,
    		$_collection,
    		$_payload;
    
    protected $resolver;
    
    /**
     * @param ApiProblemRenderer $apiProblemRenderer
     */
    public function __construct(ApiProblemRenderer $apiProblemRenderer,$config)
    {
        $this->apiProblemRenderer = $apiProblemRenderer;
        $this->config = $config;
    }
    
    /**
     * Set helper plugin manager instance.
     *
     * Also ensures that the 'Hal' helper is present.
     *
     * @param  HelperPluginManager $helpers
     */
    public function setHelperPluginManager(HelperPluginManager $helpers)
    {
        if (!$helpers->has('Hal')) {
            $this->injectHalHelper($helpers);
        }
        $this->helpers = $helpers;
    }
    
    /**
     * @param  ViewEvent $event
     * @return self
     */
    public function setViewEvent(ViewEvent $event)
    {
        $this->viewEvent = $event;
        return $this;
    }
    
    /**
     * Lazy-loads a helper plugin manager if none available.
     *
     * @return HelperPluginManager
     */
    public function getHelperPluginManager()
    {
        if (!$this->helpers instanceof HelperPluginManager) {
            $this->setHelperPluginManager(new HelperPluginManager());
        }
    
        return $this->helpers;
    }
    
    /**
     * @return ViewEvent
     */
    public function getViewEvent()
    {
        return $this->viewEvent;
    }

    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return mixed
     */
    public function getEngine()
    {
        return $this;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  ResolverInterface $resolver
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Render values as XML
     *
     * @param  string|ModelInterface $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof XmlModel) {
            return $this->_render($nameOrModel, $values);
        }

        throw new Exception\DomainException(sprintf(
            '%s: Do not know how to handle operation when both $nameOrModel and $values are populated',
            __METHOD__
        ));
    }
    
    protected function _render($nameOrModel, $values = null)
    {   
        if ($nameOrModel->isEntity()) {
            $helper  = $this->helpers->get('Hal');
            $payload = $helper->renderEntity($nameOrModel->getPayload());
        }
    
        if ($nameOrModel->isCollection()) {
            $helper  = $this->getHelperPluginManager()->get('Hal');
            $payload = $helper->renderCollection($nameOrModel->getPayload());
    
            if ($payload instanceof ApiProblem) {
                return $this->renderApiProblem($payload);
            }
            
        }
    
        return $nameOrModel->serialize();
    }
}