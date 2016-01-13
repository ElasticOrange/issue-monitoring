$(document).ready(function(){

    $("input[data-action=active-user]").click(function(){
        var request = $.ajax({
            url: $(this).attr('update-url'),
            data: {
                active: $(this).prop('checked')
            },
            method:'get'
        });
        request.done(function(data){
        });
    });

    function initDate() {
        var startDateWidgets = $('#startdate-subscription').datetimepicker({
            locale: 'ro',
            format: 'L',
            defaultDate: moment()
        });

        $('#startdate-result').val(($('#startdate-subscription').val()).split(".").reverse().join("-"));

        startDateWidgets.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('#startdate-result').val(e);
        });

        var endDateWidgets = $('#enddate-subscription').datetimepicker({
            locale: 'ro',
            format: 'L',
            defaultDate: moment()
        });

        $('#enddate-result').val(($('#enddate-subscription').val()).split(".").reverse().join("-"));

        endDateWidgets.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('#enddate-result').val(e);
        });
    }

    initDate();
});
