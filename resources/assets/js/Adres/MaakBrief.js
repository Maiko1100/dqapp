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