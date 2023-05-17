<?php

namespace MagePsycho\GoToCatalog\Block\Adminhtml\Product\Edit\Button;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product\Url as ProductUrl;
use MagePsycho\GoToCatalog\Model\Config;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ViewInStore extends Generic
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ProductUrl
     */
    private $productUrl;

    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        Config $config,
        ProductUrl $productUrl
    ) {
        parent::__construct($context, $registry);
        $this->storeManager = $storeManager;
        $this->config = $config;
        $this->productUrl = $productUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function getButtonData()
    {
        if (!$this->canShow()) {
            return [];
        }

        return [
            'label'      => __('View in Store'),
            'on_click'   => sprintf("window.open('%s')", $this->getProductUrl()),
            'target'     => '_blank',
            'sort_order' => 11
        ];
    }

    private function canShow()
    {
        return !$this->getProduct()->isReadonly()
            && $this->config->isEnabled()
            && $this->config->isProductLinkEnabled()
            && $this->getProduct()->getUrlKey();
    }

    private function getProductUrl()
    {
        $product = clone $this->getProduct();
        $product->setStoreId($this->getCurrentStoreId());
        return $this->productUrl->getProductUrl($product);
    }

    private function getCurrentStoreId()
    {
        $currentStoreId = (int)$this->storeManager->getStore()->getId();
        if ($currentStoreId === \Magento\Store\Model\Store::DEFAULT_STORE_ID) {
            $currentStoreId = $this->storeManager->getDefaultStoreView()->getId();
        }

        return $currentStoreId;
    }
}
