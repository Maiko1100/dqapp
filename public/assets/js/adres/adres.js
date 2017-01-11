    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '#maakBrief', function () {
            var error = $("#error_message");
            var id = $(this).closest("tr").attr('value');
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

            var aData =
            {
                id: id,
                datum: datum,
                afspraak: afspraak,
                tijd: tijd,
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



function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);

}

    $(function () {
        $("#datepicker").datepicker({
                dateFormat: 'DD d MM yy',
                changeMonth: true,
                changeYear: true,
                minDate: 0
            },
            $.datepicker.regional['nl']);
    });
/* Dutch (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Mathias Bynens <http://mathiasbynens.be/> */

jQuery(function($){


        $.datepicker.regional.nl = {
				closeText: 'Sluiten',
                prevText: '?',
                nextText: '?',
                currentText: 'Vandaag',
                monthNames: ['januari', 'februari', 'maart', 'april', 'mei', 'juni',
                'juli', 'augustus', 'september', 'oktober', 'november', 'december'],
                monthNamesShort: ['jan', 'feb', 'maa', 'apr', 'mei', 'jun',
                'jul', 'aug', 'sep', 'okt', 'nov', 'dec'],
                dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
                dayNamesShort: ['zon', 'maa', 'din', 'woe', 'don', 'vri', 'zat'],
                dayNamesMin: ['zo', 'ma', 'di', 'wo', 'do', 'vr', 'za'],
                dateFormat: 'dd/mm/yy', firstDay: 1,
				
                isRTL: false};
				
        $.datepicker.setDefaults($.datepicker.regional.nl);
});
//# sourceMappingURL=adres.js.map
