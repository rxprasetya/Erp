$(document).ready(function () {
    $(document).on('change', '.materialID', function () {
        let selectedOption = $(this).find('option:selected')
        let unit = selectedOption.data('unit')

        $(this).closest('.form-group').find('.unitText').text(unit)
    });

    $('.materialID').each(function () {
        let initialUnit = $(this).find('option:selected').data('unit')
        if (initialUnit) {
            $(this).closest('.form-group').find('.unitText').text(initialUnit)
        }
    })

})
