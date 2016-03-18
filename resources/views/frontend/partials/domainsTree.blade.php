<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        @foreach($domains as $domain)
            @if (empty($publicDomainsTree[$domain->id]['subdomains'])) 
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
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-domain-{{ $domain->id }}" aria-expanded="false" aria-controls="collapse-domain-{{ $domain->id }}">
                            {{ $domain->name }}
                        </a>
                    </h4>
                </div>
                <div id="collapse-domain-{{ $domain->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="domain-heading-{{ $domain->id }}">
                    <div class="panel-body">
                        @include('frontend.partials.domainsTreeItems', ['domains' => $publicDomainsTree[$domain->id]['subdomains']])
                    </div>
                </div>
            @endif

        @endforeach

    </div>
</div>
