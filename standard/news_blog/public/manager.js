/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

createNewRecord = function (form) {
    
    var data = {
        'rel': 'zone',
        'type': 'zone',
        'websiteId': '0',
        'action': 'createPage'
    }
    
    data.buttonTitle = $('input[name="i_n_0"]').val();
    data.languageId = $('input[name="i_n_1"]').val();
    data.zoneName = $('input[name="i_n_2"]').val();
    var postUrl = $('input[name="i_n_3"]').val();
    
    $.ajax({
        type : 'POST',
        url : postUrl,
        data : data,
        context : form,
        success : _createNewRecordAnswer,
        dataType : 'json'
    });
    return false;
}


_createNewRecordAnswer = function (response) {
    if (response && response.status == 'success') {
        window.location = window.location;
    } else {
        console.log(response);
    }
}



deleteRecord = function (recordId, confirmationMessage, postUrl) {
    if (confirm(confirmationMessage)) {
        var data = {
            'rel': 'zone',
            'type': 'page',
            'websiteId': '0',
            'action': 'deletePage',
            'pageId': recordId,
            'languageId': $('input[name="i_n_1"]').val(),
            'zoneName': $('input[name="i_n_2"]').val()
        }
        $.ajax({
            type : 'POST',
            url : postUrl,
            data : data,
            success : _deleteRecordAnswer,
            dataType : 'json'
        });
        return false;
    }
}


_deleteRecordAnswer = function (response) {
    if (response && response.status == 'success') {
        window.location = window.location;
    } else {
        console.log(response);
    }
}