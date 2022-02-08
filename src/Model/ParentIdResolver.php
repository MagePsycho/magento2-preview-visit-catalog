<?php

namespace MagePsycho\GoToCatalog\Model;

use Magento\Bundle\Model\ResourceModel\Selection as BundleSelection;
use Magento\Catalog\Model\Product\Type as ProductType;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;
use Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable as ConfigurableTypeResource;
use Magento\GroupedProduct\Model\Product\Type\Grouped as GroupedType;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ParentIdResolver
{
    /**
     * @var ConfigurableTypeResource
     */
    private $configurable;

    /**
     * @var BundleSelection
     */
    private $bundle;

    /**
     * @var GroupedType
     */
    private $grouped;

    public function __construct(
        ConfigurableTypeResource $configurable,
        BundleSelection $bundle,
        GroupedType $grouped
    ) {
        $this->configurable = $configurable;
        $this->bundle = $bundle;
        $this->grouped = $grouped;
    }

    public function getParentId($productId, $typeId)
    {
        $parentIds = [];
        if ($typeId == ConfigurableType::TYPE_CODE) {
            $parentIds = $this->configurable->getParentIdsByChild($productId);
        } elseif ($typeId == ProductType::TYPE_BUNDLE) {
            $parentIds = $this->bundle->getParentIdsByChild($productId);
        } elseif ($typeId == GroupedType::TYPE_CODE) {
            $parentIds = $this->grouped->getParentIdsByChild($productId);
        }
        return $parentIds[0] ?? false;
    }
}
