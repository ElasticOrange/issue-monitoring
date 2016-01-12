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

});
