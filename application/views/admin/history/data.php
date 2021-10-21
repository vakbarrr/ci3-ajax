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
            <a href="<?= base_url('admin/history/add') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <button type="button" onclick="reload_ajax()" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
        </div>
        <?= form_open('admin/history/delete', array('id' => 'bulk')) ?>
        <table id="history" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Year</th>
                    <th>Subyear</th>
                    <th>Description</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <?= form_close() ?>
    </div>
</div>

<script>
    var table;

    $(document).ready(function() {
        ajaxcsrf();

        table = $("#history").DataTable({
            initComplete: function() {
                var api = this.api();
                $("#history_filter input")
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
                url: base_url + "admin/history/data",
                type: "POST"
            },
            columns: [{
                    data: "history_id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "year"
                },
                {
                    data: "subyear"
                },
                {
                    data: "description"
                },
            ],
            columnDefs: [{
                searchable: false,
                targets: 4,
                data: {
                    history_id: "history_id",
                },
                render: function(data, type, row, meta) {
                    let btn;
                    return `<div class="text-center">
							<a href="${base_url}admin/history/edit/${data.history_id}" class="btn btn-xs btn-warning">
								<i class="fa fa-pencil"></i> Edit
							</a>
                              <button class="btn btn-xs btn-danger hapus-history" data-id="${data.history_id}"><i class="fa fa-trash"></i> Delete</button>
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
            .appendTo("#history_wrapper .col-md-6:eq(0)");

        $(".select_all").on("click", function() {
            if (this.checked) {
                $(".check").each(function() {
                    this.checked = true;
                    $(".select_all").prop("checked", true);
                });
            } else {
                $(".check").each(function() {
                    this.checked = false;
                    $(".select_all").prop("checked", false);
                });
            }
        });

        $("#history tbody").on("click", "tr .check", function() {
            var check = $("#history tbody tr .check").length;
            var checked = $("#history tbody tr .check:checked").length;
            if (check === checked) {
                $(".select_all").prop("checked", true);
            } else {
                $(".select_all").prop("checked", false);
            }
        });

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
        if ($("#history tbody tr .check:checked").length == 0) {
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

    $('#history').on('click', '.hapus-history', function() {
        let history_id = $(this).attr("data-id");
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
                    url: `<?= base_url('admin/history/delete/${history_id}') ?>`,
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
                        history_id: "history_id",
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