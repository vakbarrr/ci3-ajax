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
            <a href="<?= base_url('admin/insight/addcategory') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <button type="button" onclick="reload_ajax()" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
        </div>
        <?= form_open('admin/insight/deletecategory', array('id' => 'bulk')) ?>
        <table id="category" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Category Name</th>
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

        table = $("#category").DataTable({
            initComplete: function() {
                var api = this.api();
                $("#category_filter input")
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
                url: base_url + "admin/insight/datacategory",
                type: "POST"
            },
            columns: [{
                    data: "category_id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "category_name"
                }
            ],
            columnDefs: [{
                searchable: false,
                targets: 2,
                data: {
                    category_id: "category_id",
                },
                render: function(data, type, row, meta) {
                    let btn;
                    return `<div class="text-center">
							<a href="${base_url}admin/insight/editcategory/${data.category_id}" class="btn btn-xs btn-warning">
								<i class="fa fa-pencil"></i> Edit
							</a>
                            <button class="btn btn-xs btn-danger hapus-category" data-id="${data.category_id}"><i class="fa fa-trash"></i> Delete</button>
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

    $('#category').on('click', '.hapus-category', function() {
        let category_id = $(this).attr("data-id");
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
                    url: `<?= base_url('admin/category/delete/${category_id}') ?>`,
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
                        category_id: "category_id",
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