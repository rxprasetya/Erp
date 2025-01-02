$(document).ready(function () {
    const materialsTemplate = $('.materials').first().clone()
    $('.materials').hide()

    $('#bomID').on('change', function () {
        const bomCode = $(this).val()

        $('.materials').not(':first').remove()
        $('.materials').first().hide()

        $.ajax({
            url: '/production/get-materials/',
            method: 'POST',
            data: {
                bomID: bomCode,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const dataBom = response.dataBom

                dataBom.forEach((data, index) => {
                    if (index === 0) {
                        const firstMaterial = $('.materials').first()
                        firstMaterial.show()
                        firstMaterial.find('input[name="materialName[]"]').val(`[${data.materialCode}] ${data.materialName}`)
                        firstMaterial.find('input[name="toConsume[]"]').val(data.qtyMaterial)
                        firstMaterial.find('input[name="reserved[]"]').val(data.qtyMaterial)
                    } else {
                        const newMaterial = materialsTemplate.clone()
                        newMaterial.show()
                        newMaterial.find('input[name="materialName[]"]').val(`[${data.materialCode}] ${data.materialName}`)
                        newMaterial.find('input[name="toConsume[]"]').val(data.qtyMaterial)
                        newMaterial.find('input[name="reserved[]"]').val(data.qtyMaterial)
                        $('.materials').last().after(newMaterial)
                    }
                })
            },
            error: function (xhr, status, error) {
                console.error('An error occurred while fetching materials', error)
                console.error('Response', xhr.responseText)
            }
        })
    })

    if ($('#bomID').val() != '') {
        const bomCode = $('#bomID').val()

        $.ajax({
            url: '/production/get-materials/',
            method: 'POST',
            data: {
                bomID: bomCode,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                const dataBom = response.dataBom

                dataBom.forEach((data, index) => {
                    if (index === 0) {
                        const firstMaterial = $('.materials').first()
                        firstMaterial.removeAttr('style')
                        firstMaterial.find('input[name="materialName[]"]').val(`[${data.materialCode}] ${data.materialName}`)
                        firstMaterial.find('input[name="toConsume[]"]').val(data.qtyMaterial)
                        firstMaterial.find('input[name="reserved[]"]').val(data.qtyMaterial)
                        firstMaterial.find('input[name="consumed[]"]').val(data.qtyMaterial)
                    } else {
                        const newMaterial = materialsTemplate.clone()
                        newMaterial.find('input').val('')
                        newMaterial.removeAttr('style')
                        newMaterial.find('input[name="materialName[]"]').val(`[${data.materialCode}] ${data.materialName}`)
                        newMaterial.find('input[name="toConsume[]"]').val(data.qtyMaterial)
                        newMaterial.find('input[name="reserved[]"]').val(data.qtyMaterial)
                        newMaterial.find('input[name="consumed[]"]').val(data.qtyMaterial)
                        $('.materials').last().after(newMaterial)
                    }
                })
            },
            error: function (xhr, status, error) {
                console.error('An error occurred while fetching materials:', error)
                console.error('Response:', xhr.responseText)
            },
        })
    }

    const dynamicForm = $("#dynamic-form")

    dynamicForm.on('change', '.materialID', function () {
        const materialID = $(this).val()
        const row = $(this).closest(".form-group")

        $.ajax({
            url: '/rfq/get-cost/',
            method: 'get',
            data: {
                materialID: materialID,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                const materialCost = response.materialCost
                const qty = $('.qtyOrder').val()
                row.find(".priceOrder").val(materialCost)
                row.find(".totalOrder").val(qty * materialCost)
            }
        })
    })

    dynamicForm.on('change', '.productID', function () {
        const productID = $(this).val()
        const row = $(this).closest(".form-group")


        $.ajax({
            url: '/rfq-sales/get-price/',
            method: 'get',
            data: {
                productID: productID,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                const productPrice = response.productPrice.price
                const resultPrice = Math.round(productPrice * 1.1)
                const qty = $('.qtySold').val()
                row.find(".priceSale").val(resultPrice)
                row.find(".totalSold").val(qty * resultPrice)
            }
        })
    })

    $('#check').on('click', function (e) {
        e.preventDefault()
        const bomCode = $('#bomID').val()

        $.ajax({
            url: '/production/is-available/',
            method: 'POST',
            data: {
                bomID: bomCode,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Available',
                        text: response.success
                    })
                    $('#check').hide()
                    $('.res').prop('hidden', false)
                    $('.btn.btn-default')
                        .removeClass('btn-default')
                        .addClass('btn-primary')
                        .prop('disabled', false)

                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Not Enough',
                        text: response.error
                    })
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                })
            }
        })
    })

})
