$(document).ready(function () {
    // Event handler for when a material is selected
    $(document).on('change', '.materialID', function () {
        // Get the selected option
        let selectedOption = $(this).find('option:selected')
        // Get the unit data from the selected option
        let unit = selectedOption.data('unit')

        // Find the unitText element in the same row and update its text
        $(this).closest('.form-group').find('.unitText').text(unit)
    });

    // Set the initial unit for each row on page load (in case there is a pre-selected material)
    $('.materialID').each(function () {
        let initialUnit = $(this).find('option:selected').data('unit')
        if (initialUnit) {
            $(this).closest('.form-group').find('.unitText').text(initialUnit)
        }
    })

})
