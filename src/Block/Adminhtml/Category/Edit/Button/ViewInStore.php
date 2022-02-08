<?php

namespace MagePsycho\GoToCatalog\Block\Adminhtml\Category\Edit\Button;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Block\Adminhtml\Category\AbstractCategory;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category\Tree as CategoryTree;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Store\Model\StoreManagerInterface;
use MagePsycho\GoToCatalog\Model\Config;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ViewInStore extends AbstractCategory implements ButtonProviderInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        CategoryTree $categoryTree,
        Registry $registry,
        CategoryFactory $categoryFactory,
        StoreManagerInterface $storeManager,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $categoryTree, $registry, $categoryFactory, $data);
        $this->storeManager = $storeManager;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        if (!$this->canShow()) {
            return [];
        }

        return [
            'label'      => __('View in Store'),
            'on_click'   => sprintf("window.open('%s')", $this->getCategoryUrl()),
            'target'     => '_blank',
            'sort_order' => 11
        ];
    }

    public function canShow()
    {
        $category = $this->getCategory();
        $categoryId = $category->getId();
        $category->setStoreId($this->getCurrentStoreId());

        return $categoryId
            && !in_array($categoryId, $this->getRootIds())
            && $category->isDeleteable()
            && $this->config->isEnabled()
            && $this->config->isCategoryLinkEnabled()
            && $this->getCategory()->getUrlKey();
    }

    private function getCategoryUrl()
    {
        $category = $this->getCategory()->setStoreId($this->getCurrentStoreId());
        return $category->getUrl();
    }

    private function getCurrentStoreId()
    {
        $currentStoreId = (int) $this->storeManager->getStore()->getId();
        if ($currentStoreId === \Magento\Store\Model\Store::DEFAULT_STORE_ID) {
            $currentStoreId = $this->storeManager->getDefaultStoreView()->getId();
        }

        return $currentStoreId;
    }
}
