$(document).ready(function(){
    $('[data-confirm=true]').click(function(e)
    {
        if(confirm('Vrei sa stergi acest user ?'))
        {
            return true;
        }
        else
        {
            e.preventDefault();
            return false;
        }
    });
});