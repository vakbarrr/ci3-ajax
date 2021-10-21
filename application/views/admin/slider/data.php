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

            <a href="<?= base_url('admin/slider/add') ?>" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-plus"></i> Tambah data</a>
            <button type="button" onclick="reload_ajax()" class="btn btn-flat btn-sm bg-maroon"><i class="fa fa-refresh"></i> Reload</button>
        </div>
    </div>
    <?= form_open('admin/slider/delete', array('id' => 'bulk')) ?>
    <div class="table-responsive px-4 pb-3" style="border: 0">
        <table id="slider" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">
                        <input type="checkbox" class="select_all">
                    </th>
                    <th width="25">No.</th>
                    <th>Title</th>
                    <th>Photo</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <?= form_close(); ?>
</div>

<script>
    let table;

    $(document).ready(function() {
        ajaxcsrf();

        table = $("#slider").DataTable({
            initComplete: function() {
                let api = this.api();
                $("#slider_filter input")
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
                url: base_url + "admin/slider/data",
                type: "POST"
            },
            columns: [{
                    data: "slider_id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "slider_id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "title"
                },
                {
                    data: "photo"
                }
            ],
            columnDefs: [{
                    targets: 0,
                    data: "slider_id",
                    render: function(data, type, row, meta) {
                        return `<div class="text-center">
									<input name="checked[]" class="check" value="${data}" type="checkbox">
								</div>`;
                    }
                },
                {
                    targets: 4,
                    data: "slider_id",
                    render: function(data, type, row, meta) {
                        return `
                                <a href="${base_url}admin/slider/edit/${data}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                 <a href="${base_url}admin/slider/delete/${data}" onclick="bulk_delete()" class="btn btn-xs btn-danger">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </div>`;
                    }
                }
            ],
            order: [
                [1, "desc"]
            ],
            rowId: function(a) {
                return a;
            },
            rowCallback: function(row, data, iDisplayIndex) {
                let info = this.fnPagingInfo();
                let page = info.iPage;
                let length = info.iLength;
                let index = page * length + (iDisplayIndex + 1);
                $("td:eq(1)", row).html(index);
            }
        });

        table
            .buttons()
            .container()
            .appendTo("#slider_wrapper .col-md-6:eq(0)");

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
                            text: "Data berhasil dihapus",
                            type: "success"
                        });
                    } else {
                        Swal({
                            title: "Gagal",
                            text: "gagal hapus",
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
</script>