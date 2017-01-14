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
    });