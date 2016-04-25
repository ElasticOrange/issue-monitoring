@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-10 col-md-offset-1">
            <h1>Contact</h1>
            <hr />
            <div class="col-md-8 col-sm-8">

                <p>
                    <b>ASOCIAȚIA CENTRUL PENTRU MONITORIZAREA POLITICILOR PUBLICE</b>, cu sediul în Municipiul București, Sector 2, Aleea Tibiscum, nr. 53, et. 1, ap. 5, înregistrată în Registrul Special al Asociațiilor și Fundațiilor cu numărul 1/15.01.2015, cod de înregistrare fiscală 33974049, cont bancar RO41RNCB0074144445250001, deschis la Banca Comercială Română
                </p>

                <p>
                    <strong><i>Trimite-ne un mesaj pentru a ne spune cum te putem ajuta.</i></strong>
                </p>

                <form role="form" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nume și prenume</label>
                        <input type="text" name="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Mesaj</label>
                        <textarea name="body" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Trimite" class="btn btn-primary btn-large" />
                    </div>
                </form>
            </div>

            <div class="col-md-4 col-sm-4 sidebar2">
                <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script><div style='overflow:hidden;height:280px;width:280px;'><div id='gmap_canvas' style='height:280px;width:280px;'></div><div><small><a href="http://embedgooglemaps.com">heightembed google maps</a></small></div><div><small><a href="http://googlemapsgenerator.com">googlemapsgenerator.com</a></small></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type='text/javascript'>function init_map(){var myOptions = {zoom:15,center:new google.maps.LatLng(44.42602753427105,26.125318626983685),mapTypeId: google.maps.MapTypeId.TERRAIN};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(44.42602753427105,26.125318626983685)});infowindow = new google.maps.InfoWindow({content:'<strong>Sediu IssueMonitoring</strong><br>Bulevardul Unirii Nr. 76, Bucuresti<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
                <h2>Date de contact</h2>
                <address>
                    <strong>Adresa de corespondență:</strong><br>
                    București, Sector 3, Bulevardul Unirii Nr. 76, Bloc J3a, Et. 8, Ap. 64, Interfon 264<br>
                    Telefon: 031.080.2370<br>
                    Fax: 031.080.2371<br>
                    E-mail: office@cmpp.ro
                </address>
                <address>
                    <strong>Alexandra Preda – Project Manager</strong><br>0727144025<br>
                    <a href="mailto:alexandra.preda@cmpp.ro">alexandra.preda@cmpp.ro</a>
                </address> 
            </div>

        </div>
    </div>
    @include('frontend.layout.footer')
</div>

@endsection
