<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title">
            <a class="accordion-toggle collapsed"
                  data-toggle="collapse"
                  data-parent="#issues"
                  href="#issues_{{ $issue->id }}"
                  aria-expanded="false"
            >
                <i class="indicator glyphicon glyphicon-plus"></i>
                {{ $issue->name}}
            </a>
        </h5>
    </div>
    <div id="issues_{{ $issue->id }}" class="panel-collapse collapse" aria-expanded="false">
        <div class="panel-body">
            <span><b>Nr. înreg. Parlament:</b> Pl-x 242/2015</span>
            <br>
            <span><b>Data start:</b> 2014-06-23</span>
            <br>
                              Propunerea legislativă are
            ca obiect reglementarea metodelor de extracție a hidrocarburilor
            neconvenționale pe teritoriul României, urmărindu-se instituirea unui
            mecanism legislativ și instituțional care să permită exploatarea acestor resurse
            pe baza unor tehnologii mai eficiente și lipsite de riscuri pentru mediu,
            economie și comunitățile locale.                            
            <p>
                <br>
                <b><a href="{{ action('HomeController@getContact') }}" rel="nofollow">Pentru a accesa mai multe informații, vă rugăm să ne contactați !</a></b>
            </p>
        </div>
    </div>
</div>
