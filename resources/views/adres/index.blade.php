@extends('layouts.app')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript" src="{{ asset('assets/js/adres/adres.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/adres/adres.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Zoeken</div>

                    @if ( isset($error) )
                        <div class="alert alert-warning fade in alert-margin">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>{{$error}}</strong>
                        </div>
                    @endif

                    <div hidden id="alert" class="alert alert-warning fade in alert-margin">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <div id="error_message"></div>
                    </div>
                    <div hidden id="succes" class="alert alert-success fade in alert-margin">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <div id="succes_message"></div>
                    </div>
                    <div class="panel-body">
                        
                        <form method="POST" action="{{ url('adres/search') }}" accept-charset="UTF-8">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <div class="col-lg-6 margin-bottom">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="postcode_huisnummer"
                                           placeholder="Search for...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Zoek</button>
                                </span>
                                </div>
                            </div>

                        </form>

                        @if ( isset($adressen) )
                            <div>
                                <div class="col-lg-12">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="row">
                                        <div class="col-lg-6">

                                            <input name="datum" autocomplete="off" type="text" class="form-control"
                                                   placeholder="Klik voor datum" id="datepicker"/>
                                        </div>
                                    </div>


                                    <div class="row margin-top">
                                        <div class="col-md-4">
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="afspraak" value="meten"> Inmeten
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="afspraak" value="zetten"> Zetten
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row margin-top margin-bottom">
                                        <div class="col-lg-6">
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="tijd" value="Ochtend"> Ochtend
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="tijd" value="Tussen"> Tussen
                                                </label>
                                                <label class="btn btn-primary">
                                                    <input type="radio" name="tijd" value="Middag"> Middag
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row margin-top margin-bottom">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="email"
                                                   placeholder="Emailadres(optioneel)">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-10">
                                    <table class="table table-striped table-bordered table-hover table-condensed"
                                           id="table">
                                        <tr>
                                            <th>Straat</th>
                                            <th>Postcode</th>
                                            <th>Woonplaats</th>
                                            <th>Naam</th>
                                            <th>Mail</th>
                                            <th>Brief</th>
                                        </tr>


                                        @foreach ($adressen as $adres)

                                            <tr name='id' value={{$adres['id']}} >
                                                <td>{{ $adres['straat'] }} {{ $adres['huisnummer'] }} {{ $adres['toevoeging'] }}</td>
                                                <td>{{ $adres['postcode'] }}</td>
                                                <td>{{ $adres['stad'] }}</td>
                                                <td>{{ $adres['naam'] }}</td>
                                                <td>
                                                    <button class="btn" id="mailBrief">mail</button>
                                                </td>
                                                <td>
                                                    <button class="btn" id="maakBrief">Brief</button>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </table>
                                    <form id="brief" action="adres/brief"></form>
                                </div>

                            </div>



                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

