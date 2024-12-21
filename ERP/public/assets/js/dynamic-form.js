$(document).ready(function () {
    const dynamicForm = $("#dynamic-form");

    $(this).find(".btn-hapus").hide();

    // Saat tombol Tambah diklik
    $(document).on("click", ".btn-tambah", function (e) {
        e.preventDefault();

        // Kloning baris pertama
        const newRow = $("#dynamic-form .form-group:first").clone();
        newRow.find("input, select").val(""); // Reset nilai input
        newRow.find(".unitText").text("-"); // Reset teks
        dynamicForm.append(newRow); // Tambahkan baris baru ke form

        updateButtons(); // Perbarui tampilan tombol
    });

    // Saat tombol Hapus diklik
    $(document).on("click", ".btn-hapus", function (e) {
        e.preventDefault();

        // Hapus baris
        $(this).closest(".form-group").remove();

        updateButtons(); // Perbarui tampilan tombol
    });

    // Fungsi untuk memperbarui tombol Tambah dan Hapus
    function updateButtons() {
        const rows = $("#dynamic-form .form-group");

        rows.each(function (index) {
            const isLastRow = index === rows.length - 1;

            // Tampilkan tombol Tambah hanya pada baris terakhir
            $(this).find(".btn-tambah").toggle(isLastRow);

            // Tampilkan tombol Hapus di semua baris
            $(this).find(".btn-hapus").toggle(rows.length > 1);;
        });
    }

    $(document).on("input", ".qtyOrder, .priceOrder", function () {
        const row = $(this).closest(".form-group")
        const qtyOrder = row.find(".qtyOrder").val()
        const priceOrder = row.find(".priceOrder").val()

        const result = qtyOrder * priceOrder
        row.find(".totalOrder").val(result)
    })

    // Inisialisasi tombol saat pertama kali halaman dimuat
    updateButtons();
});