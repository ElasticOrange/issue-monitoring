@foreach($domains as $domain)
        @if (empty($publicDomainsTree[$domain->id]['subdomains']))
            <li class="list-group-item">
                <a href="{{ action('HomeController@getReports', ['domain' => $domain->id]) }}"
                    id-domain="{{ $domain->id }}"
                >
                    {{ $domain->translate(App::getLocale())->name }}
                </a>
            </li>
        @endif
@endforeach
