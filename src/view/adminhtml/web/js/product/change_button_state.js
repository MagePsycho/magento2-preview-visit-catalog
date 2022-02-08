/**
 *  @category   MagePsycho
 *  @package    MagePsycho_GoToCatalog
 *  @author     Raj KB <info@magepsycho.com>
 *  @website    https://www.magepsycho.com
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require(['jquery'], function ($) {

    function changeButtonState() {
        var $viewInStore = $('#mpViewInStore');
        if (!$viewInStore.length) {
            return;
        }

        if ($('[name="product[status]"]').val() == 2 || $('[name="product[visibility]"]').val() == 1) {
            $viewInStore.prop("disabled", true);
        } else {
            $viewInStore.prop("disabled", false);
        }
    }

    $(document).on('change', '[name="product[status]"]', function () {
        changeButtonState();
    });

    $(document).on('change', '[name="product[visibility]"]', function () {
        changeButtonState();
    });

    $(document).ajaxComplete(function (event, request, settings) {
        changeButtonState();
    });
});
