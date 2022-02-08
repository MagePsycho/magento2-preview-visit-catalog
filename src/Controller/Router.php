<?php

namespace MagePsycho\GoToCatalog\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use MagePsycho\GoToCatalog\Helper\Data as GoToCatalogHelper;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * Response
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var GoToCatalogHelper
     */
    protected $goToCatalogHelper;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ManagerInterface $eventManager,
        GoToCatalogHelper $goToCatalogHelper
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->eventManager = $eventManager;
        $this->goToCatalogHelper = $goToCatalogHelper;
    }

    public function match(RequestInterface $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        if (empty($pathInfo)) {
            return;
        }

        $condition = new DataObject(['identifier' => $pathInfo, 'continue' => true]);
        $this->eventManager->dispatch(
            'magepsycho_gotocatalog_controller_router_match_before',
            ['router' => $this, 'condition' => $condition]
        );

        if ($condition->getRedirectUrl()) {
            $this->response->setRedirect($condition->getRedirectUrl());
            $request->setDispatched(true);
            return $this->actionFactory->create(
                \Magento\Framework\App\Action\Redirect::class,
                ['request' => $request]
            );
        }

        if (!$condition->getContinue()) {
            return null;
        }

        $identifier = $condition->getIdentifier();
        $params = explode('/', $identifier);
        $requestIdentifier = $params[0] ?? '';

        $skuRedirectIdentifier = $this->goToCatalogHelper->getConfig()->getCustomProductUrlKey();
        if ($requestIdentifier == $skuRedirectIdentifier) {
            $sku = $params[1] ?? '';
            $request->setModuleName('magepsycho_gotocatalog')
                ->setControllerName('redirect')
                ->setActionName('bySku')
                ->setParam('sku', $sku);

            return $this->actionFactory->create(
                \Magento\Framework\App\Action\Forward::class,
                ['request' => $request]
            );
        }

        return null;
    }
}
