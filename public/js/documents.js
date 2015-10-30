$(document).ready(function(){
    $('[data-confirm=true]').click(function(e)
    {
        if(confirm('Vrei sa stergi acest document ?'))
        {
            return true;
        }
        e.preventDefault();
        return false;
    });
});
