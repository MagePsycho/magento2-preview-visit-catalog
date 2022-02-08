<?php

namespace MagePsycho\GoToCatalog\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Config implements ConfigInterface
{
    const XML_PATH_ENABLED = 'magepsycho_gotocatalog/general/enabled';
    const XML_PATH_DEBUG = 'magepsycho_gotocatalog/general/debug';

    const XML_PATH_ENABLE_PRODUCT_LINK = 'magepsycho_gotocatalog/catalog/enable_product_link';
    const XML_PATH_ENABLE_CATEGORY_LINK = 'magepsycho_gotocatalog/catalog/enable_category_link';
    const XML_PATH_CUSTOM_PRODUCT_URL_KEY = 'magepsycho_gotocatalog/catalog/product_url_key';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function getConfigFlag($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getConfigValue($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLED, $storeId);
    }

    public function isDebugEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_DEBUG, $storeId);
    }

    public function isProductLinkEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLE_PRODUCT_LINK, $storeId);
    }

    public function isCategoryLinkEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLE_CATEGORY_LINK, $storeId);
    }

    public function getCustomProductUrlKey($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOM_PRODUCT_URL_KEY, $storeId);
    }
}
