const base_url = $('meta[name="base_url"]').attr('content');

function get(t) {
    if ("undefined" != typeof Storage) return localStorage.getItem(t);
    alert("Please use a modern browser as this site needs localstroage!");
}
function store(t, e) {
    "undefined" != typeof Storage ? localStorage.setItem(t, e) : alert("Please use a modern browser as this site needs localstroage!");
}
function remove(t) {
    "undefined" != typeof Storage ? localStorage.removeItem(t) : alert("Please use a modern browser as this site needs localstroage!");
}

function toRupiah(angka = '0', idr = false) {
    var rupiah = '';
    if (angka == null) {
        angka = '0';
    }
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    if (idr == true) {
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    } else {
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }
}

function formatRupiah(angka, rp = false) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    if (rp == true) {
        return "Rp. " + rupiah;
    } else {
        return rupiah;
    }
}

$('.buka_laci').click(function (e) {
    e.preventDefault();
    $.get(base_url + 'penjualan/buka_laci', function () {
        swal({
            title: "Berhasil!",
            text: "Laci Berhasil Dibuka",
            icon: "success",
            timer: 1500
        });
    })
})

// select2
$('.select2').select2()

// datatable
$('.datatable').dataTable();

$('.datatable-stok-opname').dataTable({
    "pageLength": 50,
});

// ubah akses role
$('.ubah_menu').click(function () {
    const id_menu = $(this).data('menu');
    const id_role = $(this).data('role');

    $.ajax({
        url: `${base_url}petugas/ubah_akses_role/${id_menu}/${id_role}`,
        method: 'post',
        success: function () {
            swal('Berhasil', 'Data berhasil diubah', 'success');
            window.location.reload(true)
        }
    })
})

$('._closeRegister').click(function () {
    swal({
        title: "Apakah anda yakin?",
        text: "Tutup register tidak dapat dikembalikan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            window.location = $(this).data('href')
        }
    });
})

// role
$(document).on('click', '.hapus_role', function () {
    hapus($(this).data('href'))
})

$(document).on('click', '.hapus_backup', function () {
    hapus($(this).data('href'))
})

$(document).on('click', '.hapus_register', function () {
    hapus($(this).data('href'))
})

$(document).on('click', '.hapus_semua_barang', function () {
    hapus($(this).data('href'))
})

$(document).on('click', '.hapus_pembayaran', function () {
    hapus($(this).data('href'))
})

$(document).on('click', '.hapus_stok_opname', function () {
    hapus($(this).data('href'))
})

$(document).on('click', '.hapus_penjualan', function () {
    hapus($(this).data('href'))
})


$('.harga_pokok').keyup(function (e) {
    const harga_pokok = $(this).val();
    const golongan_1 = $('.golongan_1').val();
    const golongan_2 = $('.golongan_2').val();
    const golongan_3 = $('.golongan_3').val();
    const golongan_4 = $('.golongan_4').val();

    $('.profit_1').val(parseInt(golongan_1) - parseInt(harga_pokok));
    $('.profit_2').val(parseInt(golongan_2) - parseInt(harga_pokok));
    $('.profit_3').val(parseInt(golongan_3) - parseInt(harga_pokok));
    $('.profit_4').val(parseInt(golongan_4) - parseInt(harga_pokok));
});

// profit
$('.golongan_1').keyup(function (e) {
    const harga_pokok = $('.harga_pokok').val();
    const golongan_1 = $(this).val();
    const profit_1 = parseInt(golongan_1) - parseInt(harga_pokok);
    $('.profit_1').val(profit_1);
    if (parseInt(golongan_1) < parseInt(harga_pokok)) {
        $(this).closest('.col-md-4').find('.form-group').addClass('has-error');
    } else {
        $(this).closest('.col-md-4').find('.form-group').removeClass('has-error');
    }
});

$('.golongan_2').keyup(function (e) {
    const harga_pokok = $('.harga_pokok').val();
    const golongan_2 = $(this).val();
    const profit_2 = parseInt(golongan_2) - parseInt(harga_pokok);
    $('.profit_2').val(profit_2);

    if (parseInt(golongan_2) < parseInt(harga_pokok)) {
        $(this).closest('.col-md-4').find('.form-group').addClass('has-error');
    } else {
        $(this).closest('.col-md-4').find('.form-group').removeClass('has-error');
    }

});

$('.golongan_3').keyup(function (e) {
    const harga_pokok = $('.harga_pokok').val();
    const golongan_3 = $(this).val();
    const profit_3 = parseInt(golongan_3) - parseInt(harga_pokok);
    $('.profit_3').val(profit_3);
    if (parseInt(golongan_3) < parseInt(harga_pokok)) {
        $(this).closest('.col-md-4').find('.form-group').addClass('has-error');
    } else {
        $(this).closest('.col-md-4').find('.form-group').removeClass('has-error');
    }

});

$('.golongan_4').keyup(function (e) {
    const harga_pokok = $('.harga_pokok').val();
    const golongan_4 = $(this).val();
    const profit_4 = parseInt(golongan_4) - parseInt(harga_pokok);
    $('.profit_4').val(profit_4)
    if (parseInt(golongan_4) < parseInt(harga_pokok)) {
        $(this).closest('.col-md-4').find('.form-group').addClass('has-error');
    } else {
        $(this).closest('.col-md-4').find('.form-group').removeClass('has-error');
    }
});

$('.nama_barang').keyup(function(){
    $('.nama_pendek').val($(this).val())
});
