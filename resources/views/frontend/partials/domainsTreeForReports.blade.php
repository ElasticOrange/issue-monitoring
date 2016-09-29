<div class="panel-group" id="domains" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        @foreach($domains as $domain)
            <div class="panel-heading" role="tab" id="domain-heading-{{ $domain->id }}">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#domains" href="#collapse-domain-{{ $domain->id }}" aria-expanded="false" aria-controls="collapse-domain-{{ $domain->id }}">
                        <i class="indicator glyphicon glyphicon-triangle-right"></i>
                        {{ $domain->translate(App::getLocale())->name }}
                    </a>
                </h4>
            </div>
            <div id="collapse-domain-{{ $domain->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="domain-heading-{{ $domain->id }}">
                <div class="panel-body">
                    @include('frontend.partials.domainsTreeItemsForReports', ['domains' => $tree[$domain->id]['subdomains']])
                </div>
            </div>
        @endforeach
    </div>
</div>
