$(document).ready(function () {
    $(document).on('click', '#delete', function (e) {
        e.preventDefault()
        let link = $(this).attr("href")

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"

        }).then((result) => {
            if (result.isConfirmed) {
                console.log(link);
                $.ajax({
                    url: link,
                    type: 'GET',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        }).then(() => {
                            location.reload()
                        })
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error"
                        })
                    }
                })
            }
        })
    })

    const successMessage = $('body').data('success-message')
    const errorMessage = $('body').data('error-message')

    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Succeed!',
            text: successMessage,
            confirmButtonText: 'OK',
        })
    }

    if (errorMessage) {
        Swal.fire({
            title: "Error!",
            text: errorMessage,
            icon: "error"
        })
    }

})