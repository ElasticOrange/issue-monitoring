<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title">
            <a class="accordion-toggle collapsed"
                  data-toggle="collapse"
                  data-parent="#issues"
                  href="#issues_{{ $issue->id }}"
                  aria-expanded="false"
            >

                <div class="glyph-background col-xs-1" style="margin-top: -4px;">
                    <i class="indicator glyphicon glyphicon-plus"></i>
                </div>
                {{ $issue->name}}
            </a>
        </h5>
    </div>
    <div id="issues_{{ $issue->id }}" class="panel-collapse collapse" aria-expanded="false">
        <div class="panel-body">
            <span><b>Data start:</b> {{ $issue->created_at->format('d-m-Y') }}</span>
            <br/><br/>
                {!! strip_tags($issue->description) !!}
            <p>
                <br>
                @if(\Auth::user())
                    <a href="{{ action('HomeController@getIssueInfo', ['id' => $issue->id, 'name' => Illuminate\Support\Str::slug($issue->name)]) }}" rel="nofollow">Mai multe detalii</a>
                @else
                    <a href="{{ action('HomeController@getContact') }}" rel="nofollow">Pentru a accesa mai multe informații, vă rugăm să ne contactați !</a>
                @endif
            </p>
        </div>
    </div>
</div>
<br />
