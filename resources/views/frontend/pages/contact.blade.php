@extends('frontend.layout.master')

@section('content')

<div class="container white">
    @include('frontend.layout.header')
    <div class="row" style="margin-top: -20px;">
        <div class="col-md-8 col-md-offset-2">
            <h1>Contact</h1>
            <hr />
            <div class="col-md-9 col-sm-9">

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

            <div class="col-md-3 col-sm-3 sidebar2">
                <h2>Date de contact</h2>
                <address>
                    <strong>Adresa de corespondență:</strong><br>
                    București, Sector 3, Str. Agricultori. 128 bis
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