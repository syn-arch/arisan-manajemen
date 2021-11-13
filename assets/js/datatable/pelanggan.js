$(function () {

    const pelangganTable = $('#table-pelanggan').dataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": base_url + "master/get_pelanggan_json",
            "type": "POST"
        },
        "columns": [
            { "data": "id_pelanggan" },
            { "data": "nama_pelanggan" },
            { "data": "alamat" },
            { "data": "jk" },
            { "data": "telepon" },
            { "data": "jenis" },
            {
                "data": "id_pelanggan",
                "render": function (data, type, row) {
                    return `<a title="ubah" class="btn btn-warning" href="${base_url}master/ubah_pelanggan/${data}"><i class="fa fa-edit"></i></a>
				<a title="hapus" class="btn btn-danger hapus_pelanggan" data-href="${base_url}master/hapus_pelanggan/${data}"><i class="fa fa-trash"></i></a>`
                }
            }
        ],
    })

    $(document).on('click', '.hapus_pelanggan', function () {
        hapus($(this).data('href'))
    })

})
