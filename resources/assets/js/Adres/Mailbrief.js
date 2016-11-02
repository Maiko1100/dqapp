$('body').on('click', '#mailBrief', function () {
    var error = $("#error_message");
    var succes = $("#succes_message");
    var id = $(this).closest("tr").attr('value');
    var datum = $('input[name=datum]').val();
    if (datum == null || datum == "") {
        $('#alert').show();
        error.text("Datum is niet ingevuld");
        return false;
    } else {
        $('#alert').hide();
    }
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
    var email = $('input[name=email]').val();
    if (!validateEmail(email)) {
        $('#alert').show();
        error.text("Email is niet correct ingevuld");
        return false;
    } else {
        $('#alert').hide();
    }

    var aData =
    {
        id: id,
        datum: datum,
        afspraak: afspraak,
        tijd: tijd,
        email: email,
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


