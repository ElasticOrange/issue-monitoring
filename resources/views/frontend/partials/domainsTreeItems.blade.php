@foreach($domains as $domain)
        @if (empty($publicDomainsTree[$domain->id]['subdomains'])) 
            <li class="list-group-item">
                <a href="{{ action('HomeController@getIssues', ['domain' => $domain->id]) }}">
                    {{ $domain->name }}
                </a>
            </li>
        @endif
@endforeach
