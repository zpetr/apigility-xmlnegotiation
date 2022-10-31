<?php
namespace zPetr\ApigilityXml\Serializer\Adapter;

use Laminas\Serializer\Adapter\AdapterOptions;

class XmlOptions extends AdapterOptions
{
    /**
     * @var string
     */
    protected $rootNode = 'root';

    /**
     * @var string
     */
    protected $xmlVersion = '1.0';

    /**
     * @var string
     */
    protected $encoding = 'UTF-8';

    /**
     * @var bool
     */
    protected $standalone = true;

    /**
     * @return boolean
     */
    public function isStandalone()
    {
        return $this->standalone;
    }

    /**
     * @param boolean $standalone
     */
    public function setStandalone($standalone)
    {
        $this->standalone = $standalone;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * @return string
     */
    public function getXmlVersion()
    {
        return $this->xmlVersion;
    }

    /**
     * @param string $xmlVersion
     */
    public function setXmlVersion($xmlVersion)
    {
        $this->xmlVersion = $xmlVersion;
    }

    /**
     * @return string
     */
    public function getRootNode()
    {
        return $this->rootNode;
    }

    /**
     * @param string $rootNode
     */
    public function setRootNode($rootNode)
    {
        $this->rootNode = $rootNode;
    }
}
