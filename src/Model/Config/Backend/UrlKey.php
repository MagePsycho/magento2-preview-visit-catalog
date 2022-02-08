<?php

namespace MagePsycho\GoToCatalog\Model\Config\Backend;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use MagePsycho\GoToCatalog\Model\Validator\UrlKey as UrlKeyValidator;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class UrlKey extends ConfigValue
{
    /**
     * @var UrlKeyValidator
     */
    private $urlKeyValidator;

    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        UrlKeyValidator $urlKeyValidator,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->urlKeyValidator = $urlKeyValidator;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave()
    {
        $urlKey = $this->getValue();
        if ($this->urlKeyValidator->validate($urlKey)) {
            throw new LocalizedException(
                __('Route %1 already exists.', $urlKey)
            );
        }

        return parent::beforeSave();
    }
}
