$(document).ready(function () {
    const dynamicForm = $("#dynamic-form")

    $(this).find(".btn-hapus").hide()

    $(document).on("click", ".btn-tambah", function (e) {
        e.preventDefault()

        const newRow = $("#dynamic-form .form-group:first").clone()
        newRow.find("input, select").val("")
        newRow.find(".unitText").text("-")
        dynamicForm.append(newRow)

        updateButtons()
    })

    $(document).on("click", ".btn-hapus", function (e) {
        e.preventDefault()

        $(this).closest(".form-group").remove()

        updateButtons()
    })

    function updateButtons() {
        const rows = $("#dynamic-form .form-group")

        rows.each(function (index) {
            const isLastRow = index === rows.length - 1

            $(this).find(".btn-tambah").toggle(isLastRow)

            $(this).find(".btn-hapus").toggle(rows.length > 1)
        })
    }

    $(document).on("input", ".qtyOrder, .priceOrder", function () {
        const row = $(this).closest(".form-group")
        const qtyOrder = row.find(".qtyOrder").val()
        const priceOrder = row.find(".priceOrder").val()

        const result = qtyOrder * priceOrder
        row.find(".totalOrder").val(result)
    })

    $(document).on("input", ".qtySold, .priceSale", function () {
        const row = $(this).closest(".form-group")
        const qtySold = row.find(".qtySold").val()
        const priceSale = row.find(".priceSale").val()

        const result = qtySold * priceSale
        row.find(".totalSold").val(result)
    })

    updateButtons()
})