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

            <a href="<?= base_url('admin/insight/add') ?>" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-plus"></i> Tambah data</a>
            <button type="button" onclick="reload_ajax()" class="btn btn-flat btn-sm bg-maroon"><i class="fa fa-refresh"></i> Reload</button>
        </div>
    </div>
    <?= form_open('admin/insight/delete', array('id' => 'bulk')) ?>
    <div class="table-responsive px-4 pb-3" style="border: 0">
        <table id="insight" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th width="25">No.</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Data</th>
                    <th>Category</th>
                    <th>Photo</th>
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

        table = $("#insight").DataTable({
            initComplete: function() {
                var api = this.api();
                $("#insight_filter input")
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
                url: base_url + "admin/insight/data",
                type: "POST"
            },
            columns: [{
                    data: "insight_id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "insight_title"
                },
                {
                    data: "insight_content"
                },
                {
                    data: "insight_date"
                },
                {
                    data: "category_id"
                },
                {
                    data: "photos"
                },
            ],
            columnDefs: [{
                searchable: false,
                targets: 6,
                data: {
                    insight_id: "insight_id",
                },
                render: function(data, type, row, meta) {
                    let btn;
                    return `<div class="text-center">
							<a href="${base_url}admin/insight/edit/${data.insight_id}" class="btn btn-xs btn-warning">
								<i class="fa fa-pencil"></i> Edit
							</a>
                             <button class="btn btn-xs btn-danger hapus-insight" data-id="${data.insight_id}"><i class="fa fa-trash"></i> Delete</button>
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
            .appendTo("#insight_wrapper .col-md-6:eq(0)");

        $("#bulk").on("submit", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $.ajax({
                url: $(this).attr("action"),
                data: $(this).serialize(),
                type: "POST",
                success: function(respon) {
                    if (respon.status) {
                        Swal({
                            title: "Berhasil",
                            text: " data berhasil dihapus",
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
                },
                error: function() {
                    Swal({
                        title: "Gagal",
                        text: "Ada data yang sedang digunakan",
                        type: "error"
                    });
                }
            });
        });

    });

    function bulk_delete() {
        if ($("#insight tbody tr .check:checked").length == 0) {
            Swal({
                title: "Gagal",
                text: "Tidak ada data yang dipilih",
                type: "error"
            });
        } else {
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
    }

    $('#insight').on('click', '.hapus-insight', function() {
        let insight_id = $(this).attr("data-id");
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
                    url: `<?= base_url('admin/insight/delete/${insight_id}') ?>`,
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
                        insight_id: "insight_id",
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