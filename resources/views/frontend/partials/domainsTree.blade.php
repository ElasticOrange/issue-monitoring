<div class="panel-group" id="domains" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        @foreach($domains as $domain)
            @if (empty($tree[$domain->id]['subdomains']))
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#{{ $domain->name }}">
                            {{ $domain->name }}
                        </a>
                    </h4>
                </div>
            @else
                <div class="panel-heading" role="tab" id="domain-heading-{{ $domain->id }}">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#domains" href="#collapse-domain-{{ $domain->id }}" aria-expanded="false" aria-controls="collapse-domain-{{ $domain->id }}">
                            <i class="indicator glyphicon glyphicon-triangle-right"></i>
                            {{ $domain->name }}
                        </a>
                    </h4>
                </div>
                <div id="collapse-domain-{{ $domain->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="domain-heading-{{ $domain->id }}">
                    <div class="panel-body">
                        @include('frontend.partials.domainsTreeItems', ['domains' => $tree[$domain->id]['subdomains']])
                    </div>
                </div>
            @endif

        @endforeach
    </div>
</div>
