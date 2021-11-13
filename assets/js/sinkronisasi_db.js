const data_penjualan = JSON.parse($.ajax({
    url: base_url + 'api/get_penjualan/' + $('.tgl_sinkron').val(),
    dataType: "json",
    async: false
}).responseText);

const data_detail_penjualan = JSON.parse($.ajax({
    url: base_url + 'api/get_detail_penjualan/' + $('.tgl_sinkron').val(),
    dataType: "json",
    async: false
}).responseText);

const data_biaya = JSON.parse($.ajax({
    url: base_url + 'api/get_biaya/' + $('.tgl_sinkron').val(),
    dataType: "json",
    async: false
}).responseText);

const data_pembayaran = JSON.parse($.ajax({
    url: base_url + 'api/get_pembayaran/' + $('.tgl_sinkron').val(),
    dataType: "json",
    async: false
}).responseText);

const data_register = JSON.parse($.ajax({
    url: base_url + 'api/get_register/' + $('.tgl_sinkron').val(),
    dataType: "json",
    async: false
}).responseText);

const data_pelanggan = JSON.parse($.ajax({
    url: base_url + 'api/get_pelanggan',
    dataType: "json",
    async: false
}).responseText);



$('.download_data_transaksi').click(function (e) {
    e.preventDefault();
    console.log($('.tgl_sinkron').val());
    swal({
        title: "Apakah anda yakin?",
        text: "Data yang disinkronkan tidak bisa dikembalikan! \n pastikan koneksi internet anda stabil",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: 'GET',
                url: url_server + '/api/get_data_transaksi/',
                timeout: 0, // Infinite
                data: {
                    id_outlet: id_outlet,
                    tgl: $('.tgl_sinkron').val()
                },
                beforeSend: function () {
                    $('.loader_wrapper').html(`<div class="loader"></div>`)
                },
                success: function (respon) {

                    $.ajax({
                        url: base_url + 'api/sync_data_transaksi',
                        method: 'POST',
                        data: {
                            pelanggan: JSON.stringify(respon.pelanggan),
                            register: JSON.stringify(respon.register),
                            penjualan: JSON.stringify(respon.penjualan),
                            detail_penjualan: JSON.stringify(respon.detail_penjualan),
                            biaya: JSON.stringify(respon.biaya),
                            pembayaran: JSON.stringify(respon.pembayaran),
                            id_outlet: id_outlet,
                            tgl: $('.tgl_sinkron').val()
                        },
                        success: function () {
                            $('.loader_wrapper').html(``)
                            swal('Berhasil', 'Sinkronisasi Berhasil', 'success');
                        }
                    })

                },
                error: function (request, status, err) {
                    $('.loader_wrapper').html(``)
                    swal('Gagal', (status == "timeout") ? "Timeout" : "error: " + err, 'error');
                }
            });
        }
    });
});

$('.upload_data_transaksi').click(function (e) {
    e.preventDefault();
    console.log($('.tgl_sinkron').val());

    swal({
        title: "Apakah anda yakin?",
        text: "Data yang disinkronkan tidak dapat dikembalikan! \n pastikan koneksi internet anda stabil",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: 'POST',
                url: url_server + '/api/sync_data_transaksi',
                timeout: 0, // Infinite
                data: {
                    tgl: $('.tgl_sinkron').val(),
                    id_outlet: id_outlet,
                    pelanggan: JSON.stringify(data_pelanggan),
                    register: JSON.stringify(data_register),
                    penjualan: JSON.stringify(data_penjualan),
                    detail_penjualan: JSON.stringify(data_detail_penjualan),
                    biaya: JSON.stringify(data_biaya),
                    pembayaran: JSON.stringify(data_pembayaran)
                },
                beforeSend: function () {
                    $('.loader_wrapper').html(`<div class="loader"></div>`)
                },
                success: function (respon) {
                    $('.loader_wrapper').html(``)
                    swal('Berhasil', 'Sinkronisasi Berhasil', 'success');
                },
                error: function (request, status, err) {
                    $('.loader_wrapper').html(``)
                    swal('Gagal', (status == "timeout") ? "Timeout" : "error: " + err, 'error');
                }
            });
        }
    });
});

$('.download_data_master').click(function (e) {
    e.preventDefault();
    console.log($('.tgl_sinkron').val());
    swal({
        title: "Apakah anda yakin?",
        text: "Data yang disinkronkan tidak dapat dikembalikan! \n pastikan koneksi internet anda stabil",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: 'GET',
                url: url_server + '/api/get_data_master',
                timeout: 0, // Infinite
                beforeSend: function () {
                    $('.loader_wrapper').html(`<div class="loader"></div>`)
                },
                success: function (respon) {

                    $.ajax({
                        url: base_url + 'api/download_data_master',
                        method: 'POST',
                        data: {
                            kategori: JSON.stringify(respon.kategori),
                            supplier: JSON.stringify(respon.supplier),
                            petugas: JSON.stringify(respon.petugas),
                            karyawan: JSON.stringify(respon.karyawan),
                            barang: JSON.stringify(respon.barang)
                        },
                        success: function () {
                            $('.loader_wrapper').html(``)
                            swal('Berhasil', 'Sinkronisasi Berhasil', 'success');
                        }
                    })
                },
                error: function (request, status, err) {
                    $('.loader_wrapper').html(``)
                    swal('Gagal', (status == "timeout") ? "Timeout" : "error: " + err, 'error');
                }
            });
        }
    });
})

$('.download_stok').click(function (e) {
    e.preventDefault();
    console.log($('.tgl_sinkron').val());
    swal({
        title: "Apakah anda yakin?",
        text: "Data yang disinkronkan tidak dapat dikembalikan! \n pastikan koneksi internet anda stabil",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url_server + '/api/get_stok',
                method: 'GET',
                timeout: 0,
                beforeSend: function () {
                    $('.loader_wrapper').html(`<div class="loader"></div>`)
                },
                success: function (respon) {
                    $.ajax({
                        url: base_url + 'api/update_stok',
                        method: 'POST',
                        data: {
                            stok_outlet: JSON.stringify(respon)
                        },
                        success: function () {
                            $('.loader_wrapper').html(``)
                            swal('Berhasil', 'Update Stok Berhasil!', 'success');
                        }
                    })
                },
                error: function (request, status, err) {
                    $('.loader_wrapper').html(``)
                    swal('Gagal', (status == "timeout") ? "Timeout" : "error: " + err, 'error');
                }
            });
        }
    });
})
