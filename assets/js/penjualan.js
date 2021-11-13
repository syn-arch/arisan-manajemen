$(function () {

    $('.barcode').focus();

    myTable = $('#table-cari-barang').DataTable({
        "processing": true,
        "serverSide": true,
        "keys": {
            keys: [ 13 /* ENTER */, 38 /* UP */, 40 /* DOWN */ ]
        },
        "order": [],
        "ajax": {
            "url": base_url + "barang/get_harga_barang_json/",
            "type": "POST"
        },
        "columns": [
        { "data": "id_barang" },
        { "data": "nama_barang" },
        {
            "data": "golongan_1",
            render: $.fn.dataTable.render.number('.', '.', 0, '')
        },
        {
            "data": "golongan_2",
            render: $.fn.dataTable.render.number('.', '.', 0, '')
        },
        {
            "data": "golongan_3",
            render: $.fn.dataTable.render.number('.', '.', 0, '')
        },
        {
            "data": "golongan_4",
            render: $.fn.dataTable.render.number('.', '.', 0, '')
        },
        { "data": "stok_q" },
        ],
    });

    $('#table-cari-barang').on('key-focus.dt', function(e, datatable, cell){
        $(myTable.row(cell.index().row).node()).addClass('selected');
    });

    $('#table-cari-barang').on('key-blur.dt', function(e, datatable, cell){
        $(myTable.row(cell.index().row).node()).removeClass('selected');
    });

    $('#table-cari-barang').on('key.dt', function(e, datatable, key, cell, originalEvent){
        className = $(originalEvent.target).attr("class").split(/\s+/)[1];
        
        if (className != 'cash') {
            if(key == 13){
                var data = myTable.row(cell.index().row).data();
                tambah_chart(data.id_barang);
            }
        }
    });       

    $('#table-cari-barang').on('dblclick','tr',function(e){
        e.stopPropagation()                       
        id = myTable.rows(this).data()[0].id_barang
        tambah_chart(id);
    })

    // slight update to account for browsers not supporting e.which
    function disableF5(e) {
        if ((e.which || e.keyCode) == 116) {
            e.preventDefault();
            swal({
                title: "Apakah anda yakin?",
                text: "Transaksi akan dibatalkan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    location.reload(true)
                }
            });
        }
    };

    // disable refresh
    // $(document).on("keydown", disableF5);

    $('.hold-penjualan').click(function (e) {
        e.preventDefault();
        $('.form-penjualan').attr('action', base_url + 'penjualan/proses/true');
        $('.form-penjualan').submit();
    })

    $('.ship_nama').hide()
    $('.ship_alamat').hide()

    $('#kirim').click(function () {
        if ($(this).prop('checked') == true) {
            $('.ship_nama').show()
            $('.ship_alamat').show()
        } else {
            $('.ship_nama').hide()
            $('.ship_alamat').hide()
        }
    })

    $('.no_debit').hide()
    $('.no_kredit').hide()
    $('.lampiran').hide()

    $('.metode_pembayaran').change(function () {
        const val = $(this).val()
        if (val == 'Cash') {
            $('.no_debit').hide()
            $('.no_kredit').hide()
            $('.lampiran').hide()
        } else {
            $('.no_debit').show()
            $('.no_kredit').show()
            $('.lampiran').show()
        }
    })

    function get_subtotal() {
        let total = 0;
        $(document).find('.subtotal').each(function (index, element) {
            total += parseInt($(element).text().replace('Rp. ', '').replace('.', '').replace('.', '').replace('.', ''));
        });

        return total;
    }

    function tambah_lagi(id_barang, harga_jual, golongan, qtyPlus) {

        item = $.parseJSON($.ajax({
            url: base_url + 'barang/get_barang/' + id_barang + '/' + golongan,
            dataType: "json",
            async: false
        }).responseText);

        item.diskon == null ? diskon = 0 : diskon = item.diskon;

        harga = item.harga_jual - (diskon / 100) * item.harga_jual;

        $(document).find('td[data-secret="' + id_barang + '"]').text(toRupiah(harga_jual, true));
        $(document).find('input[data-id="' + id_barang + '"]').attr('data-harga', harga_jual);
        $(document).find('input[data-golongan="' + id_barang + '"]').val(golongan);

        $('input[data-id="' + id_barang + '"]').val(qtyPlus);

        $(document).find('input[data-subtot="' + id_barang + '"]').val(qtyPlus * harga);
        $(document).find('td[data-kode="' + id_barang + '"]').html(toRupiah(qtyPlus * harga, true));

        if (pengaturan.kunci_penjualan == 1) {
            $('a[data-id="' + data.id_barang + '"]').attr('data-qty', qtyPlus);
        }
    }

    function tambah_chart(id, qty = '1') {

        if (qty == '') {
            qty = 1;
        } else {
            qty = parseFloat(qty)
        }

        $.get(base_url + 'barang/get_brg/' + id, function (res) {
            data = JSON.parse(res)
            if (data == null) {
                swal({
                    title: "Error!",
                    text: "Barang tidak ditemukan silahkan cari lagi!",
                    icon: "error",
                    timer: 1500
                });
                $('.qty_brg').val('');
                $('.barcode').focus();
                return
            }

            data.diskon == null ? diskon = 0 : diskon = data.diskon;

            harga_jual = data.golongan_1

            harga_brg = harga_jual - (diskon / 100) * harga_jual;

            let subtot = qty * harga_brg;

            const cari = $(document).find('tr[data-id="' + data.id_barang + '"]');

            if (cari.length > 0) {

             swal({
                title: "Error!",
                text: "Barang Sudah ditambahkan",
                icon: "error",
                timer: 1500
            });
             $('.qty_brg').val('');
             $('.barcode').focus();

         } else {
            html = `
            <tr data-id="${data.id_barang}">
            <input type="hidden" name="id_barang[]" value="${data.id_barang}">
            <input data-subtot="${data.id_barang}" type="hidden" name="total_harga[]" value="${subtot}">
            <td width="30%">${data.nama_pendek}</td>
            <td>
            <select class="form-control gl" name="type_golongan[]">
            <option value="golongan_1">G 1</option>
            <option value="golongan_2">G 2</option>
            <option value="golongan_3">G 3</option>
            <option value="golongan_4">G 4</option>
            </select>
            </td>
            <td data-secret="${data.id_barang}" class="harga_brg">${toRupiah(harga_jual, true)}</td>
            <td>${diskon}</td>
            <td>
            <input autocomplete="off" class="form-control qty" step="0.1" name="jumlah[]" data-id="${data.id_barang}" data-harga="${harga_brg}" type="number" value="${qty}" style="width: 5em">
            </td>
            <td class="subtotal" data-kode="${data.id_barang}">${toRupiah(subtot, true)}</td>
            <td><a class="btn btn-danger btn-flat hapus-barang" data-id="${data.id_barang}" data-harga="${harga_brg}"><i class="fa fa-trash"></i></a></td>
            </tr>
            `;

            $('.penjualan-item').append(html);
        }

        $('.jumlah_bayar').val(toRupiah(get_subtotal()));
        $('.total_jumlah_bayar').val(toRupiah(get_subtotal()));

        $('.barcode').val('');
        $('.qty_brg').val('');
        $('.barcode').focus();

        updateKembalian();
        updateTotalItem();
        myTable.cell.blur();


    });
    }

    $(document).on('change', '.gl', function(){
        golongan = $(this).val()
        id_barang = $(this).closest('tr').find('input[name="id_barang[]"]').val()
        qty = $(this).closest('tr').find('.qty').val()

        $.ajax({
            method: 'get',
            url: base_url + 'barang/get_all_golongan/' + id_barang +'/' + golongan,
            success: function (res) {
                data = JSON.parse(res)
                $(document).find('td[data-secret="' + id_barang + '"]').text(toRupiah(data, true));
                $(document).find('input[data-subtot="' + id_barang + '"]').val(data * qty);
                $(document).find('td[data-kode="' + id_barang + '"]').text(toRupiah(data * qty, true));

                $('.jumlah_bayar').val(toRupiah(get_subtotal()));
                $('.total_jumlah_bayar').val(toRupiah(get_subtotal()));

                updateKembalian();
            }
        })
    })

    function updateKembalian() {
        let subtotal = get_subtotal();
        const cash = $(document).find('.cash').val();
        if (parseFloat(cash) > 0) {
            const baru = cash - subtotal;
            $('.kembalian').val(toRupiah(baru));
        }
    }

    function updateTotalItem() {
        let total = 0;
        $(document).find('.qty').each(function (index, element) {
            total += 1
        });

        $('.total_item').val(total)

    }


    $(document).on('click', '.tambah-barang', function () {
        const id = $(this).data('id');
        const qty = $('.qty_brg').val();
        tambah_chart(id, qty);
    })

    $(document).on('click', '.hapus-barang', function (e) {
        e.preventDefault();

        $(this).closest('tr').remove();
        $('.harga').html('Rp. 0');

        const id = $(this).data('id');

        const harga = $(this).closest('tr[data-id="' + id + '"]').find('input[data-id="' + id + '"]').attr('data-harga');
        const qty = $(this).closest('tr[data-id="' + id + '"]').find('input[data-id="' + id + '"]').val();

        const jumlah = parseFloat(harga) * parseFloat(qty);
        const jumlah1 = get_subtotal() + jumlah;
        const jumlah2 = parseFloat(jumlah1) - jumlah;

        $('.jumlah_bayar').val(toRupiah(jumlah2));
        $('.total_jumlah_bayar').val(toRupiah(jumlah2));
        $('.barcode').focus();
        updateKembalian();
        updateTotalItem();
        
    })

    $(document).on('click', '.batal', function (e) {
        e.preventDefault();
        $('.penjualan-item').html('');
        $('.harga').html('Rp. 0');
        $('.kembalian').html('');
        $('.cash').val('');
        $('.kembalian').val('');
        $('.qty_brg').val('');
        $('.jumlah_bayar').val('Rp. 0');
        $('.total_jumlah_bayar').val('Rp. 0');
        $('.barcode').focus();
    })


    $('.cash').keyup(function (e) {
        $(this).val(formatRupiah($(this).val()));

        cash = $(this).val().replace('.', '').replace('.', '').replace('.', '');
        const jumlah = parseFloat($('.jumlah_bayar').val().replace('Rp. ', '').replace('.', '').replace('.', '').replace('.', ''));

        const member = $('.member').val();

        jumlahAkhir = jumlah;

        let kembalian = toRupiah(parseFloat(cash) - parseFloat(jumlahAkhir));
        if (kembalian == 'Rp. NaN') {
            kembalian = "Rp. 0";
        }
        $('.kembalian').val(kembalian);
    })

    $('.form-penjualan').submit(function(e){
        e.preventDefault();
        form = $(this)

        jumlah = parseFloat($('.jumlah_bayar').val().replace('Rp. ', '').replace('.', '').replace('.', '').replace('.', ''));
        metode = $('.metode_pembayaran').val()
        if ($('.cash').val()) {
            cash = parseInt($('.cash').val().replace('Rp. ', '').replace('.', '').replace('.', '').replace('.', ''));
        }else{
            cash = 999999999
        }

        if (metode == 'Cash' || metode == 'Debit') {
            if (cash < jumlah) {
             swal({
                title: "Error!",
                text: "Metode pembayaran cash, tidak boleh kurang dari total bayar",
                icon: "error",
                timer: 1500,
                button : false
            });
             $('.cash').focus()
             return
         }   
     }

     form[0].submit()
 })

    $(document).on('keyup change', '.qty', function (e) {

        jmlBayar = get_subtotal() ? get_subtotal() : 0

        let jumlah = $(this).val() ? $(this).val() : 1

        jumlah = parseFloat(jumlah)

        const id = $(this).data('id')

        golongan = $(this).closest('tr').find('select.gl').val()
        harga = $(this).closest('tr').find('td.harga_brg').text().replace('.', '').replace(',', '')
        tt = (parseFloat(harga) * parseFloat(jumlah));

        $(this).closest('tr').find('input[data-subtot="' + id + '"]').val(Math.round(tt));
        $(this).closest('tr').find('td[data-kode="' + id + '"]').text(toRupiah(Math.round(tt),true));

        $('.jumlah_bayar').val(toRupiah(get_subtotal()));
        $('.total_jumlah_bayar').val(toRupiah(get_subtotal()));

        updateKembalian();
        updateTotalItem();

    });

    $(document).on('keydown', '.qty', function (e) {
        if (e.which == 13) {
            $('.barcode').focus();
            return false;
        }
    })

    $('.qty_brg').keydown(function (e) {
        const id = $('.barcode').val();
        const qty = $(this).val();
        if (e.which == '13') {
            e.preventDefault();
            e.stopPropagation();
            tambah_chart(id, qty);
            $('.barcode').val('');
            $('.barcode').focus();
        }
    })  

    $('.barcode').keydown(function (e) {
        const id = $(this).val();
        const qty = $('.qty_brg').val();
        if (e.which == '13') {
            e.preventDefault();
            e.stopPropagation();
            tambah_chart(id, qty);
            $('.barcode').val('');
            $('.barcode').focus();
        }
    })  

    $('.diskon').keyup(function (e) {
        let diskon = $(this).val() ? $(this).val() : 0;

        const jumlahbayar = get_subtotal() ? get_subtotal() : 0;

        let harga_sikon = (diskon / 100) * jumlahbayar;

        if (harga_sikon == 'Nan') harga_sikon = 0;

        let potongan = $('.potongan').val() ? $('.potongan').val() : 0;

        let hasilDiskon = toRupiah(parseFloat(jumlahbayar) - parseFloat(harga_sikon) - parseFloat(potongan));
        if (hasilDiskon == 'Rp. NaN') hasilDiskon = "Rp. 0"
            $('.jumlah_bayar').val(hasilDiskon);
    });

    $('.potongan').keyup(function (e) {

        $(this).val(formatRupiah($(this).val()));

        const jumlahbayar = get_subtotal();

        let diskon = $('.diskon').val() || 0;

        const harga_sikon = (parseFloat(diskon) / 100) * jumlahbayar;

        potongan_rupiah = $(this).val().replace('.', '').replace('.', '').replace('.', '') || 0;
        let hasilDiskon = toRupiah(parseFloat(jumlahbayar) - harga_sikon - parseFloat(potongan_rupiah));
        if (hasilDiskon == 'Rp. NaN') hasilDiskon = "Rp. 0"

            $('.jumlah_bayar').val(hasilDiskon);
    })

    $('.barcode_pelanggan').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            const barcode = $(this).val();
            $.get(base_url + 'pelanggan/get_pelanggan/' + barcode, function (res) {
                if (res == 'null') {
                    swal({
                        title: "Error!",
                        text: "Pelanggan tidak ditemukan!",
                        icon: "error",
                        timer: 1500
                    });
                } else {
                    const data = JSON.parse(res)
                    $.get(base_url + 'penjualan/get_limit_pelanggan/' + data.id_pelanggan, function (response) {
                        if (response == 'true') {
                            swal({
                                title: "Error!",
                                text: "Pelanggan masih memiliki piutang!",
                                icon: "error",
                                timer: 1500
                            });
                        } else {
                            $('.pelanggan').val(data.id_pelanggan)
                        }
                    });
                }
            });
            $(this).val('')
        }
    })



    $('.form-control.input-sm').keyup(function (e) {
        if (e.keyCode == 13) {
            table = $(document).find("#table-cari-barang");
            tr = $(table).find('tr')
            td = $(tr).find('td')
            id = td[0].innerHTML;
            qty = $('.qty_brg').val()
            tambah_chart(id, qty);
            $(this).val('')
        }
    });

    function shortcut(e) {

        if (e.keyCode == 112) { // F1
            e.preventDefault();

            search = $('.barcode').val();
            myTable.search(search).draw();

            setTimeout(function() {               
                myTable.row(':eq(0)', { page: 'current' }).select();
                myTable.cell( ':eq(0)' ).focus();
                if (!myTable.data().any()) {
                    $('.form-control.input-sm').focus()
                }
                $('.form-control.input-sm').focus()
            }, 500);
        }

        if (e.keyCode == 113) { // F2
            e.preventDefault();
            $('.diskon').focus()
            $('#modal-pembayaran').modal('show'); 
        }
        if (e.keyCode == 114) { // F3
            e.preventDefault();
            $('.barcode').focus()
        }
        if (e.keyCode == 115) { // F4
            e.preventDefault();
            $('#modal-pembayaran').modal('show'); 

            setTimeout(function(){
                $('.cash').focus()
            },500)
        }
    }

    // shortcut
    $(document).on('keyup keydown', 'input', function (e) {
        shortcut(e);
    });

    $(document).on('keyup keydown', function (e) {
        shortcut(e);
    });

});
