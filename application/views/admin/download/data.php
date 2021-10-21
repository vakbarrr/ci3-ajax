<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $subjudul ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">

            <a href="<?= base_url('admin/download/add') ?>" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-plus"></i> Tambah data</a>
            <button type="button" onclick="reload_ajax()" class="btn btn-flat btn-sm bg-maroon"><i class="fa fa-refresh"></i> Reload</button>
        </div>
    </div>
    <?= form_open('admin/download/delete', array('id' => 'bulk')) ?>
    <div class="table-responsive px-4 pb-3" style="border: 0">
        <table id="download" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="25">No.</th>
                    <th>Title</th>
                    <th>File</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <?= form_close(); ?>
</div>

<script>
    var table;

    $(document).ready(function() {
        ajaxcsrf();

        table = $("#download").DataTable({
            initComplete: function() {
                var api = this.api();
                $("#download_filter input")
                    .off(".DT")
                    .on("keyup.DT", function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: base_url + "admin/download/data",
                type: "POST"
            },
            columns: [{
                    data: "download_id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "title"
                },
                {
                    data: "file"
                },
            ],
            columnDefs: [{
                searchable: false,
                targets: 3,
                data: {
                    download_id: "download_id",
                },
                render: function(data, type, row, meta) {
                    let btn;
                    return `<div class="text-center">
							<a href="${base_url}admin/download/edit/${data.download_id}" class="btn btn-xs btn-warning">
								<i class="fa fa-pencil"></i> Edit
							</a>
                              <button class="btn btn-xs btn-danger hapus-download" data-id="${data.download_id}"><i class="fa fa-trash"></i> Delete</button>
						</div>`;
                }
            }],
            order: [
                [1, "asc"]
            ],
            rowId: function(a) {
                return a;
            },
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $("td:eq(0)", row).html(index);
            }
        });

        table
            .buttons()
            .container()
            .appendTo("#download_wrapper .col-md-6:eq(0)");

        $("#bulk").on("submit", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $.ajax({
                url: $(this).attr("action"),
                data: new FormData(this),
                type: "POST",
                success: function(respon) {
                    if (respon.status) {
                        Swal({
                            title: "Berhasil",
                            text: "Data berhasil dihapus",
                            type: "success"
                        });
                    } else {
                        Swal({
                            title: "Gagal",
                            text: "Tidak ada data yang dipilih",
                            type: "error"
                        });
                    }
                    reload_ajax();
                }
            });
        });
    });

    function bulk_delete() {
        Swal({
            title: "Anda yakin?",
            text: "Data akan dihapus!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus!"
        }).then(result => {
            if (result.value) {
                $("#bulk").submit();
            }
        });
    }
    $('#download').on('click', '.hapus-download', function() {
        let download_id = $(this).attr("data-id");
        swal({
            title: 'Konfirmasi',
            text: "Anda ingin menghapus ",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `<?= base_url('admin/download/delete/${download_id}') ?>`,
                    type: 'POST',
                    beforeSend: function() {
                        swal({
                            title: 'Menunggu',
                            html: 'Memproses data',
                            onOpen: () => {
                                swal.showLoading()
                            }
                        })
                    },
                    data: {
                        download_id: "download_id",
                    },
                    success: function(data) {
                        swal(
                            'Hapus',
                            'Berhasil Terhapus',
                            'success'
                        )
                        reload_ajax()
                    }
                })
            } else if (result.dismiss === swal.DismissReason.cancel) {
                swal(
                    'Batal',
                    'Anda membatalkan penghapusan',
                    'error'
                )
            }
        })
    });
</script>