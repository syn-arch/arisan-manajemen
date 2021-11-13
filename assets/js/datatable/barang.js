$(function () {

    const barangTable = $('#table-barang').dataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + "master/get_barang_json",
            "type": "POST"
        },
        "columns": [
            { "data": "id_barang" },
            { "data": "nama_barang" },
            { "data": "barcode" },
            { "data": "nama_kategori" },
            { "data": "nama_supplier" },
            { "data": "satuan" },
            {
                "data": "harga_pokok",
                render: $.fn.dataTable.render.number('.', '.', 0, '')
            },
            {
                "data": "golongan_1",
                render: $.fn.dataTable.render.number('.', '.', 0, '')
            },
            { "data": "stok" },
            { "data": "diskon" },
            {
                "data": "id_barang",
                "render": function (data, type, row) {
                    return `
				<a title="ubah" class="btn btn-warning" href="${base_url}master/ubah_barang/${data}"><i class="fa fa-edit"></i></a>
				<a title="cetak barcode" target="_blank" class="btn btn-info" href="${base_url}master/get_barcode/${data}"><i class="fa fa-barcode"></i></a>
				<a title="hapus" class="btn btn-danger hapus_barang" data-href="${base_url}master/hapus_barang/${data}"><i class="fa fa-trash"></i></a>`
                }
            }
        ],
    })

    $(document).on('click', '.hapus_barang', function () {
        hapus($(this).data('href'))
    })

})
