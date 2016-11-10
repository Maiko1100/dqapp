@extends('layouts.app')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Maak brief</div>
                    @if ( isset($error) )
                        <div class="alert alert-danger fade in alert-margin">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>{{$error}}</strong>
                        </div>
                    @endif
                    <div hidden style="margin: 5px" id="alert" class="alert alert-warning fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <div id="error_message"></div>
                    </div>
                    <div class="container-fluid">
                        <div class="row" style="margin-top: 5px">
                            <div class="col-md-4">
                                <input name="naam" type="text" placeholder="Naam" class="form-control"/>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-md-4">
                                <input name="straat" type="text" placeholder="Straat" class="form-control"/>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-md-4">
                                <input name="postcode" type="text" placeholder="Postcode" class="form-control"/>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-md-4">
                                <input name="woonplaats" type="text" placeholder="Woonplaats" class="form-control"/>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px">
                            <div class="col-lg-6">

                                <input name="datum" autocomplete="off" type="text" class="form-control"
                                       placeholder="Klik voor datum" id="datepicker"/>
                            </div>
                        </div>

                        <div style="margin-top: 5px" class="row">
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
                        <div style="margin-top: 5px; margin-bottom: 5px" class="row">
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
                        <div style="margin-top: 5px; margin-bottom: 5px" class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="email"
                                       placeholder="Emailadres(optioneel)">
                            </div>
                        </div>

                        <button id="maakBrief" style="margin-bottom: 5px" class="btn btn-primary">Maak
                            brief
                        </button>

                        <button id="mailBrief" style="margin-bottom: 5px" class="btn btn-primary">Email
                            brief
                        </button>

                    </div>
                    <script>
                        $(document).ready(function () {

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $('body').on('click', '#maakBrief', function () {
                                var soort = "createBrief";
                                var error = $("#error_message");

                                var datum = $('input[name=datum]').val();

                                if (datum == null || datum == "") {
                                    $('#alert').show();
                                    error.text("Datum is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var email = $('input[name=email]').val();

                                var afspraak = $('input[name=afspraak]:checked').val();
                                if (afspraak == null || afspraak == "") {
                                    $('#alert').show();
                                    error.text("Afspraak is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var tijd = $('input[name=tijd]:checked').val();
                                if (tijd == null || tijd == "") {
                                    $('#alert').show();
                                    error.text("Tijd is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var naam = $('input[name=naam]').val();
                                if (naam == null || naam == "") {
                                    $('#alert').show();
                                    error.text("Naam is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var straat = $('input[name=straat]').val();
                                if (straat == null || straat == "") {
                                    $('#alert').show();
                                    error.text("Straat is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var postcode = $('input[name=postcode]').val();
                                if (postcode == null || postcode == "") {
                                    $('#alert').show();
                                    error.text("Postcode is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var woonplaats = $('input[name=woonplaats]').val();
                                if (woonplaats == null || woonplaats == "") {
                                    $('#alert').show();
                                    error.text("Woonplaats is niet ingevuld");
                                    return false;
                                } else {

                                    $('#alert').hide();
                                }


                                var aData =
                                {
                                    datum: datum,
                                    afspraak: afspraak,
                                    tijd: tijd,
                                    naam: naam,
                                    straat: straat,
                                    woonplaats: woonplaats,
                                    postcode: postcode,
                                    soort : soort,
                                };

                                $.ajax({
                                    type: "POST",
                                    url: '/brief',
                                    data: aData,
                                    success: function (aData) {
                                        console.log(aData);
                                        $('#postRequestData').html(aData);
                                        window.open('/download/' + aData, '_blank');

                                    }
                                });


                            });
                            $('body').on('click', '#mailBrief', function () {
                                var error = $("#error_message");

                                var datum = $('input[name=datum]').val();

                                if (datum == null || datum == "") {
                                    $('#alert').show();
                                    error.text("Datum is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var email = $('input[name=email]').val();

                                var afspraak = $('input[name=afspraak]:checked').val();
                                if (afspraak == null || afspraak == "") {
                                    $('#alert').show();
                                    error.text("Afspraak is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var tijd = $('input[name=tijd]:checked').val();
                                if (tijd == null || tijd == "") {
                                    $('#alert').show();
                                    error.text("Tijd is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var naam = $('input[name=naam]').val();
                                if (naam == null || naam == "") {
                                    $('#alert').show();
                                    error.text("Naam is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var straat = $('input[name=straat]').val();
                                if (straat == null || straat == "") {
                                    $('#alert').show();
                                    error.text("Straat is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var postcode = $('input[name=postcode]').val();
                                if (postcode == null || postcode == "") {
                                    $('#alert').show();
                                    error.text("Postcode is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }
                                var woonplaats = $('input[name=woonplaats]').val();
                                if (woonplaats == null || woonplaats == "") {
                                    $('#alert').show();
                                    error.text("Woonplaats is niet ingevuld");
                                    return false;
                                } else {
                                    $('#alert').hide();
                                }


                                var aData =
                                {
                                    datum: datum,
                                    afspraak: afspraak,
                                    tijd: tijd,
                                    naam: naam,
                                    straat: straat,
                                    woonplaats: woonplaats,
                                    postcode: postcode,
                                };

                                $.ajax({
                                    type: "POST",
                                    url: '/mail',
                                    data: aData,
                                    success: function (aData) {

                                        console.log(aData);
                                        $('#postRequestData').html(aData);
                                        $('#succes').show();
                                        succes.text("Email succesvol verstuurd!");


                                    }
                                });


                            });
                        });
                        function validateEmail(email) {
                            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            return re.test(email);

                        }
                        $(function () {
                            $("#datepicker").datepicker({
                                        dateFormat: 'DD d MM yy',
                                        changeMonth: true,
                                        changeYear: true,
                                    },
                                    $.datepicker.regional['nl']);
                        });

                    </script>


                </div>
                <style>
                    #datepicker {
                        position: relative;
                        z-index: 100;
                    }

                </style>
            </div>
        </div>
    </div>

@endsection
