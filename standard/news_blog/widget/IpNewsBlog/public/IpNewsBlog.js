/**
 * @package ImpressPages
 * @copyright Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

function IpWidget_IpNewsBlog(widgetObject) {
    this.widgetObject = widgetObject;

    this.manageInit = manageInit;
    this.prepareData = prepareData;


    function manageInit() {
        
        var instanceData = this.widgetObject.data('ipWidget');
    }

    function prepareData() {
        var data = Object();

        data.stream = this.widgetObject.find('.ipaStream').val();
        data.limit = this.widgetObject.find('.ipaLimit').val();
        data.paginate = this.widgetObject.find('.ipaPagination').attr('checked');
        
        $(this.widgetObject).trigger('preparedWidgetData.ipWidget', [ data ]);
    }



};

