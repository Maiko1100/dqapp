    $(function () {
        $("#datepicker").datepicker({
                dateFormat: 'DD d MM yy',
                changeMonth: true,
                changeYear: true,
                minDate: 0
            },
            $.datepicker.regional['nl']);
    });