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
        const bomCode = $('#bomID').val();

        $.ajax({
            url: '/production/get-materials/',
            method: 'POST',
            data: {
                bomID: bomCode,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                const dataBom = response.dataBom;

                dataBom.forEach((data, index) => {
                    if (index === 0) {
                        const firstMaterial = $('.materials').first();
                        firstMaterial.removeAttr('style'); // Tampilkan elemen awal
                        firstMaterial.find('input[name="materialName[]"]').val(`[${data.materialCode}] ${data.materialName}`);
                        firstMaterial.find('input[name="toConsume[]"]').val(data.qtyMaterial);
                        firstMaterial.find('input[name="reserved[]"]').val(data.qtyMaterial);
                        firstMaterial.find('input[name="consumed[]"]').val(data.qtyMaterial);
                    } else {
                        const newMaterial = materialsTemplate.clone();
                        newMaterial.find('input').val(''); // Bersihkan input sebelum diisi
                        newMaterial.removeAttr('style'); // Tampilkan elemen baru
                        newMaterial.find('input[name="materialName[]"]').val(`[${data.materialCode}] ${data.materialName}`);
                        newMaterial.find('input[name="toConsume[]"]').val(data.qtyMaterial);
                        newMaterial.find('input[name="reserved[]"]').val(data.qtyMaterial);
                        newMaterial.find('input[name="consumed[]"]').val(data.qtyMaterial);
                        $('.materials').last().after(newMaterial); // Tambahkan setelah elemen terakhir
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('An error occurred while fetching materials:', error);
                console.error('Response:', xhr.responseText);
            },
        });
    }

    $('#check').on('click', function (e) {
        e.preventDefault()
        const bomCode = $('#bomID').val();

        $.ajax({
            url: '/production/is-available/',  // Correct endpoint URL
            method: 'POST',
            data: {
                bomID: bomCode,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // Hide or prevent the display of the raw JSON response.
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Available',
                        text: response.success
                    });
                    $('#check').hide();
                    $('.btn.btn-default')
                        .removeClass('btn-default')
                        .addClass('btn-primary')
                        .prop('disabled', false);

                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Not Enough',
                        text: response.error
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        });
    });

})
