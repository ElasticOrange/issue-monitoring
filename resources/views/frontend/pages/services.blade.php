@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-8 col-md-offset-2">
            <h2>Issue Monitoring – pachete de servicii</h2>
            <br>
            <p>Issue Monitoring este disponibil în mai multe variante de abonament, iar informaţia disponibilă poate fi personalizată în funcţie de subiectele de interes. Accesul pe platforma este securizat printr-un sistem de username şi parolă.</p>
            <p>Pachetul Standard include:</p>
            <ul>
                <li>acces pe platforma online la un domeniu specific activității clientului pentru un număr nelimitat de utilizatori (ex. energie electrică, sector bancar, IT&C etc.);</li>
                <li>acces pe platforma online la trei domenii de interes general – fiscal, legislația muncii, concurență;</li>
                <li>alerte cu privire la fluxul procedural și știrile/declarațiile relevante pentru domeniile monitorizate;</li>
                <li>identificarea stakeholderilor relevanți și monitorizarea activității lor;</li>
                <li>rapoarte săptămânale de progres privind evoluția inițiativelor monitorizate și informații semnificative din media;</li>
                <li>raport privind activitatea politică și economică internă din săptămâna în curs.</li>
            </ul>
            <p>Pachetul Premium include:</p>
            <ul>
                <li>toate funcționalitățile oferite de Pachetul Standard;</li>
                <li>prezența în Parlament la dezbaterile Comisiilor de specialitate pentru inițiativele monitorizate, inclusiv alerte în timp real cu privire la subiectele dezbătute, precum și sumarul discuțiilor;</li>
                <li>participarea la dezbaterile publice organizate de instituțiile de reglementare.</li>
            </ul>
            <p>Pachetele de servicii pot fi personalizate în funcție de numărul de inițiative și domenii monitorizate, frecvența rapoartelor și a participării la dezbaterile publice. În funcție de interesul specific al clientului, poate fi monitorizată activitatea diverselor instituții publice locale. </p>
            </br>
            <p>Serviciile Issue Monitoring pot constitui o componentă a unui pachet integrat de servicii de consultanță și public affairs oferite de către Graffiti PR.</p>
        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection