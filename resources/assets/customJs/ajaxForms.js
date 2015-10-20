$(document).ready(function() {

    function submitGenericAjaxForm(form) {
        var $form = $(form);
        var data = $form.serialize();
        var action = $form.attr('action') || window.document.location;
        var method = $form.attr('method') || 'POST';

        showLoader();
        var request = $.ajax({
            url: action,
            method: method,
            data: data,
            dataType: 'json'
        });

        request.done(function(data) {
            console.log('Ajax success: ', data);
        });

        request.fail(function(error) {
            console.error('Ajax error: ', error.responseJSON);
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
            if (!_.isPlainObject(data)) {
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
                    window[successFunctionName]();
                }
            }
        });

        request.fail(function(error) {
            var title = '<strong>' + ($(form).attr('error-message') || 'Error:')  + '</strong><br/>'
            var message = title + generateLaravelErrorList(error.responseJSON);

            showErrorMessage(message);
        });
    }

    $(document).on('submit', 'form[data-ajax=true]', function(ev) {
        ev.preventDefault();
        submitAjaxForm(this);
    });
});
