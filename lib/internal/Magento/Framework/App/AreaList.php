<?php
/**
 * Application area list
 *
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Framework\App;

class AreaList
{
    /**
     * Area configuration list
     *
     * @var array
     */
    protected $_areas = [];

    /**
     * @var \Magento\Framework\App\AreaInterface[]
     */
    protected $_areaInstances = [];

    /**
     * @var string
     */
    protected $_defaultAreaCode;

    /**
     * @var Area\FrontNameResolverFactory
     */
    protected $_resolverFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param Area\FrontNameResolverFactory $resolverFactory
     * @param array $areas
     * @param string|null $default
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        Area\FrontNameResolverFactory $resolverFactory,
        array $areas = [],
        $default = null
    ) {
        $this->objectManager = $objectManager;
        $this->_resolverFactory = $resolverFactory;
        if ($areas) {
            $this->_areas = $areas;
        }
        if ($default) {
            $this->_defaultAreaCode = $default;
        }
    }

    /**
     * Retrieve area code by front name
     *
     * @param string $frontName
     * @return null|string
     */
    public function getCodeByFrontName($frontName)
    {
        foreach ($this->_areas as $areaCode => &$areaInfo) {
            if (!isset($areaInfo['frontName']) && isset($areaInfo['frontNameResolver'])) {
                $areaInfo['frontName'] = $this->_resolverFactory->create(
                    $areaInfo['frontNameResolver']
                )->getFrontName();
            }
            if ($areaInfo['frontName'] == $frontName) {
                return $areaCode;
            }
        }
        return $this->_defaultAreaCode;
    }

    /**
     * Retrieve area front name by code
     *
     * @param string $areaCode
     * @return string
     */
    public function getFrontName($areaCode)
    {
        return isset($this->_areas[$areaCode]['frontName']) ? $this->_areas[$areaCode]['frontName'] : null;
    }

    /**
     * Retrieve area codes
     *
     * @return string[]
     */
    public function getCodes()
    {
        return array_keys($this->_areas);
    }

    /**
     * Retrieve default area router id
     *
     * @param string $areaCode
     * @return string
     */
    public function getDefaultRouter($areaCode)
    {
        return isset($this->_areas[$areaCode]['router']) ? $this->_areas[$areaCode]['router'] : null;
    }

    /**
     * Retrieve application area
     *
     * @param   string $code
     * @return  \Magento\Framework\App\Area
     */
    public function getArea($code)
    {
        if (!isset($this->_areaInstances[$code])) {
            $this->_areaInstances[$code] = $this->objectManager->create(
                'Magento\Framework\App\AreaInterface',
                ['areaCode' => $code]
            );
        }
        return $this->_areaInstances[$code];
    }
}
