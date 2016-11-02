    $(function () {
        $("#datepicker").datepicker({
                dateFormat: 'DD d MM yy',
                changeMonth: true,
                changeYear: true,
            },
            $.datepicker.regional['nl']);
    });