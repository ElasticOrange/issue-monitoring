var $successBox, $errorBox, $warningBox, successBoxTimeout, errorBoxTimeout;
var LOADER_DELAY = 200;

function redirect(url, timeout) {
    if (!timeout) {
        timeout = 1;
    }

    setTimeout(function() {
        window.document.location = url;
    } , timeout);
}
function addValueToHiddenElement(element) {
    var item = $('#domainTree').jqxTree('getSelectedItem');
    var itemId = $(item).attr('id');

    $('[data-adauga=true]').show();
    $('[data-edit=true]').addClass('hidden');
    $('[data-ajax=true]').attr("action", "/backend/domain/");
    $('input[value=PUT]').remove();

    $(element).attr("value", itemId);
    console.log("id from adauga: ", itemId);
}


function hideSuccessMessage() {
    $successBox.addClass('hidden');
    clearTimeout(successBoxTimeout);
}

function showSuccessMessage(caption) {
    hideErrorMessage();
    $successBox.find('.caption').html(caption);
    $successBox.removeClass('hidden');

    successBoxTimeout = setTimeout(function() {
        hideSuccessMessage();
    }, 5000);
}

function hideErrorMessage() {
    $errorBox.addClass('hidden');
    clearTimeout(errorBoxTimeout);
}

function showErrorMessage(caption) {
    hideSuccessMessage();
    $errorBox.find('.caption').html(caption);
    $errorBox.removeClass('hidden');

    errorBoxTimeout = setTimeout(function() {
        hideErrorMessage();
    }, 10000);
}

function hideWarningMessage() {
    $warningBox.addClass('hidden');
}

function showWarningMessage(caption) {
    hideWarningMessage();
    $warningBox.find('.caption').html(caption);
    $warningBox.removeClass('hidden');
}

function generateLaravelErrorList(errorList) {
    if(!_.isPlainObject(errorList)) {
        console.error('generateLaravelErrorList(): errorList is invalid', errorList);
        return;
    }

    var resultHtml = '';

    _.forOwn(errorList, function(messageList, formItem) {
        if (!_.isArray(messageList)) {
            console.error('generateLaravelErrorList(): messageList should be array', messageList, errorList, formItem);
            return;
        }

        _.forEach(messageList, function(errorMessage) {
            resultHtml += '<li>' + errorMessage + '</li>';
        })
    });

    return '<ul>' + resultHtml + '</ul>';
}

function getKeyFromPlaceholder(placeholder) {
    if (!_.isString(placeholder)) {
        console.error('getKeyFromPlaceholder(): placeholder is not string', placeholder);
        return;
    }

    if ((placeholder[0] !== '{') || (placeholder.substr(-1) !== '}')) {
        console.error('getKeyFromPlaceholder(): placeholder is not of form {key}', placeholder);
        return placeholder;
    }

    return placeholder.replace(/[{}]/g, '');
}

function fillPlaceholdersInString(string, data) {
    if(!_.isString(string)) {
        console.error('fillPlaceholdersInString(): string parameter should be of string type', string);
        return;
    }

    if (!_.isPlainObject(data)) {
        console.error('fillPlaceholdersInString(): data should be an object', data);
        return string;
    }

    var placeholders = string.match(/\{([a-z0-9\-_]+)\}/gi);
    var resultString = string;

    if (!placeholders.length) {
        return resultString;
    }

    _.forEach(placeholders, function(placeholder) {
        var regex = new RegExp(placeholder, 'g');
        var key = getKeyFromPlaceholder(placeholder);
        if (placeholder && data[key]) {
            resultString = resultString.replace(regex, data[key]);
        }
    });

    return resultString;
}

function showLoader() {
    loaderTimeout = setTimeout(function() {
        $('#loader').show();
        loaderTimeout = undefined;
    }, LOADER_DELAY);
}

function hideLoader() {
    clearTimeout(loaderTimeout);
    loaderTimeout = undefined;
    $('#loader').hide();
}

function submitGenericAjaxForm(form) {
    var $form = $(form);
    var formData = new FormData();

    var data = $form.serializeArray();
    $.each(data,function(key,input){
        formData.append(input.name,input.value);
    });

    if($('input[type="file"]').length) {
        var file_data = $('input[type="file"]')[0].files;

        for(var i = 0; i < file_data.length; i++){
            formData.append("file", file_data[i]);
        }
    }

    var action = $form.attr('action') || window.document.location;
    var method = $form.attr('method') || 'POST';

    showLoader();
    var request = $.ajax({
        url: action,
        method: method,
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false
    });

    request.done(function(data) {
        console.log('Ajax success: ', data);
    });

    request.fail(function(error) {
        console.error('Ajax error: ', error, error.responseJSON);
    });

    request.always(function() {
        hideLoader();
    });

    return request;
}

function submitAjaxForm(form) {
    var request = submitGenericAjaxForm(form);

    var $form = $(form);

    request.done(function(data) {
        if (! _.isPlainObject(data)) {
            console.error('submitAjaxForm(): ajax create did not receive the created item', data);
            return;
        }

        var successMessage = $form.attr('success-message');
        if (successMessage) {
            showSuccessMessage(successMessage);
        }

        var successUrl = $form.attr('success-url');

        if (successUrl) {
            redirect(fillPlaceholdersInString(successUrl, data), 1000);
        }
        var successFunctionName = $form.attr('success-function');

        if (successFunctionName) {
            if (_.isFunction(window[successFunctionName])) {
                window[successFunctionName](data);
            }
        }
    });

    request.fail(function(error) {
        var title = '<strong>' + ($(form).attr('error-message') || 'Error:')  + '</strong><br/>'
        var message = title + generateLaravelErrorList(error.responseJSON);

        showErrorMessage(message);
    });
}

function addDomainToTree(domain) {
    var tree =  $('#domainTree');
    var currentTreeItem = tree.jqxTree('getSelectedItem');
    tree.jqxTree('addTo', {label: domain['name'], id: parseInt(domain['id'])}, currentTreeItem);
    $('#myModal').modal('hide');
}

$(document).ready(function() {
    $successBox = $('.message-box.success');
    $errorBox = $('.message-box.error');
    $warningBox = $('.message-box.warning');
    $warningBox.click(function() {
        hideWarningMessage();
    });

    $(document).on('submit', 'form[data-ajax=true]', function(ev) {
        ev.preventDefault();
        submitAjaxForm(this);
    });

    $(document).on('click', 'button[data-modal=true]', function(ev) {
        ev.preventDefault();
        addValueToHiddenElement('[data-parent=true]');
    });
});
