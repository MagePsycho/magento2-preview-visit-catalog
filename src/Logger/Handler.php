<?php

namespace MagePsycho\GoToCatalog\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * @category   MagePsycho
 * @package    MagePsycho_GoToCatalog
 * @author     Raj KB <info@magepsycho.com>
 * @website    https://www.magepsycho.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Handler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/magepsycho_gotocatalog.log';

    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;
}
