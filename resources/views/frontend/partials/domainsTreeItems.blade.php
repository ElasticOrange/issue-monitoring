
@foreach($domains as $domain)
    @if (empty($publicDomainsTree[$domain->id]['subdomains'])) 
        <a href="#{{ $domain->name }}">
            {{ $domain->name }}
        </a>
    @endif

@endforeach
