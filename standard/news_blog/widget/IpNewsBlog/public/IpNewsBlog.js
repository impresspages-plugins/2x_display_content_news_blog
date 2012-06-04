/**
 * @package ImpressPages
 * @copyright Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

"use strict";

function IpWidget_IpNewsBlog(widgetObject) {
    this.widgetObject = widgetObject;

    this.manageInit = manageInit;
    this.prepareData = prepareData;
    this._togglRecordsPerPage = _togglRecordsPerPage;


    function manageInit() {
        var instanceData = this.widgetObject.data('ipWidget');
        var $recordsPerPageField = this.widgetObject.find('.ipaRecordsPerPage');
        if (!this.widgetObject.find('.ipaPagination').find('input').attr('checked')) {
            $recordsPerPageField.hide();
        }
        this.widgetObject.find('.ipaPagination').find('input').click({widgetObject:this.widgetObject}, this._togglRecordsPerPage);
    }
    
    function _togglRecordsPerPage(event) {
        var $widgetObject = event.data.widgetObject;
        $widgetObject.find('.ipaRecordsPerPage').toggle();
    }

    function prepareData() {
        var data = Object();

        data.stream = this.widgetObject.find('.ipaStream select').val();
        data.titleLevel = this.widgetObject.find('.ipaTitleLevel select').val();
        if (this.widgetObject.find('.ipaShowReadMore input').attr('checked')) {
            data.showReadMore = 1;
        } else {
            data.showReadMore = 0;
        }
        if (this.widgetObject.find('.ipaPagination input').attr('checked')) {
            data.pagination = 1;
        } else {
            data.pagination = 0;
        }
        data.recordsPerPage = this.widgetObject.find('.ipaRecordsPerPage input').val();
        
        $(this.widgetObject).trigger('preparedWidgetData.ipWidget', [ data ]);
    }



};

