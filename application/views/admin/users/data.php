<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $subjudul ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-3">
            <button type="button" onclick="reload_ajax()" class="btn btn-sm btn-flat bg-purple"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <label for="show_me">
                    <input type="checkbox" id="show_me">
                    Tampilkan saya
                </label>
            </div>
        </div>
    </div>
    <div class="table-responsive px-4 pb-3" style="border: 0">
        <table id="users" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    var user_id = '<?= $user->id ?>';
</script>

<script>
    var table;

    $(document).ready(function() {
        ajaxcsrf();

        table = $("#users").DataTable({
            initComplete: function() {
                var api = this.api();
                $("#users_filter input")
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
                url: base_url + "admin/users/data/" + user_id,
                type: "POST"
            },
            columns: [{
                    data: "id",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "first_name"
                },
                {
                    data: "last_name"
                },
                {
                    data: "username"
                },
                {
                    data: "email"
                },
                {
                    data: "level"
                },
                {
                    data: "created_on"
                }
            ],
            columnDefs: [{
                    targets: 5,
                    data: "level",
                    render: function(data, type, row, meta) {
                        return `<div class="text-center">
                            <span class="badge">${data}</span>
                        </div>`;
                    }
                },
                {
                    targets: 7,
                    orderable: false,
                    searchable: false,
                    title: "Status",
                    data: "active",
                    render: function(data, type, row, meta) {
                        if (data === "1") {
                            return `<div class="text-center">
                                <span class="badge bg-green">Active</span>
                            </div>`;
                        } else {
                            return `<div class="text-center">
                                <span class="badge bg-red">Not Active</span>
                            </div>`;
                        }
                    }
                },
                {
                    targets: 8,
                    data: "id",
                    render: function(data, type, row, meta) {
                        if (data === user_id) {
                            return `<div class="text-center">
                                <a class="btn btn-xs bg-primary" href="${base_url}admin/users/edit/${data}">
                                    <i class="fa fa-cog fa-spin"></i>
                                </a>
                            </div>`;
                        } else {
                            return `<div class="text-center">
                                <a class="btn btn-xs btn-warning" href="${base_url}admin/users/edit/${data}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-xs btn-danger" onclick="hapus(${data})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>`;
                        }
                    }
                }
            ],
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
            .appendTo("#users_wrapper .col-md-6:eq(0)");

        $("#show_me").on("change", function() {
            let src = base_url + "admin/users/data";
            let url = $(this).prop("checked") === true ? src : src + "/" + user_id;
            table.ajax.url(url).load();
        });
    });

    function hapus(id) {
        Swal({
            title: "Anda yakin?",
            text: "Data akan dihapus.",
            type: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus!"
        }).then(result => {
            if (result.value) {
                $.getJSON(base_url + "admin/users/delete/" + id, function(data) {
                    Swal({
                        title: data.status ? "Berhasil" : "Gagal",
                        text: data.status ?
                            "User berhasil dihapus" :
                            "User gagal dihapus",
                        type: data.status ? "success" : "error"
                    });
                    reload_ajax();
                });
            }
        });
    }
</script>