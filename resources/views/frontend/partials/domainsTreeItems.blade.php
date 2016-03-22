@foreach($domains as $domain)
        @if (empty($publicDomainsTree[$domain->id]['subdomains'])) 
            <li class="list-group-item">
                <a href="#{{ $domain->name }}">
                    {{ $domain->name }}
                </a>
            </li>
        @endif
@endforeach
