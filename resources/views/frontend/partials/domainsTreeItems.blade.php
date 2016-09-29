@foreach($domains as $domain)
        @if (empty($publicDomainsTree[$domain->id]['subdomains']))
            <li class="list-group-item">
                <a href="{{ action('HomeController@getIssues', ['domain' => $domain->id, 'issue_search' => '', 'type' => '', 'phase'=> 'curent']) }}"
                    id-domain="{{ $domain->id }}"
                >
                    {{ $domain->translate(App::getLocale())->name }}
                </a>
            </li>
        @endif
@endforeach
