<?php

namespace MagePsycho\GoToCatalog\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Product as ProductHelper;
use Magento\Catalog\Model\Product\Type as ProductType;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;
use Magento\GroupedProduct\Model\Product\Type\Grouped as GroupedType;
use MagePsycho\GoToCatalog\Helper\Data as GoToCatalogHelper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductUrlResolver
{
    /**
     * @var GoToCatalogHelper
     */
    private $goToCatalogHelper;

    /**
     * @var ProductHelper
     */
    private $productHelper;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ParentIdResolver
     */
    private $parentIdResolver;

    public function __construct(
        GoToCatalogHelper $goToCatalogHelper,
        ProductHelper $productHelper,
        ProductRepositoryInterface $productRepository,
        ParentIdResolver $parentIdResolver
    ) {
        $this->goToCatalogHelper = $goToCatalogHelper;
        $this->productHelper = $productHelper;
        $this->productRepository = $productRepository;
        $this->parentIdResolver = $parentIdResolver;
    }

    public function getUrlBySku($sku)
    {
        try {
            $product = $this->productRepository->get($sku);
        } catch (\Exception $e) {
            // log exception
            return false;
        }

        if ($product->getTypeId() == ProductType::TYPE_SIMPLE && !$this->productHelper->canShow($product)) {
            if ($parent = $this->getParent($product->getId())) {
                $product = $parent;
            }
        }

        if ($this->productHelper->canShow($product)) {
            return $product->getProductUrl();
        }

        return false;
    }

    public function getDefaultUrl($keyword)
    {
        return $this->goToCatalogHelper->getUrl('catalogsearch/result', ['_secure' => true]) . '?q=' . $keyword;
    }

    private function getParent($productId)
    {
        $parentProduct = false;
        if ($parentId = $this->parentIdResolver->getParentId($productId, ProductType::TYPE_BUNDLE)) {
            $parentProduct  = $this->productRepository->getById($parentId);
        }

        if (!$parentProduct || ($parentProduct && !$this->productHelper->canShow($parentProduct))) {
            if ($parentId = $this->parentIdResolver->getParentId($productId, ConfigurableType::TYPE_CODE)) {
                $parentProduct = $this->productRepository->getById($parentId);
            }
        }

        if (!$parentProduct || ($parentProduct && !$this->productHelper->canShow($parentProduct))) {
            if ($parentId = $this->parentIdResolver->getParentId($productId, GroupedType::TYPE_CODE)) {
                $parentProduct = $this->productRepository->getById($parentId);
            }
        }

        return $parentProduct;
    }
}
