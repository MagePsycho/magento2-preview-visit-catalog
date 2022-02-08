<?php

namespace MagePsycho\GoToCatalog\Controller;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use MagePsycho\GoToCatalog\Helper\Data as GoToCatalogHelper;
use MagePsycho\GoToCatalog\Model\ProductUrlResolver;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class Redirect extends \Magento\Framework\App\Action\Action
{
    /**
     * Enabled config path
     */
    const XML_PATH_ENABLED = 'magepsycho_gotocatalog/general/enabled';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var GoToCatalogHelper
     */
    protected $goToCatalogHelper;

    /**
     * @var ProductUrlResolver
     */
    protected $productUrlResolver;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        GoToCatalogHelper $goToCatalogHelper,
        ProductUrlResolver $productUrlResolver
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->goToCatalogHelper = $goToCatalogHelper;
        $this->productUrlResolver = $productUrlResolver;
    }

    /**
     * Dispatch request
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE)) {
            throw new NotFoundException(__('Page not found.'));
        }
        return parent::dispatch($request);
    }
}
