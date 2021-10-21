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
    columns: [
      {
        data: "download_id",
        orderable: false,
        searchable: false
      },
      { data: "title" },
      { data: "file" },
    ],
    columnDefs: [
      {
        targets: 0,
        data: "download_id",
        render: function(data, type, row, meta) {
          return `<div class="text-center">
					<input name="checked[]" class="check" value="${data}" type="checkbox">
				</div>`;
        }
      },
      {
        targets: 6,
        data: "download_id",
        render: function(data, type, row, meta) {
          return `<div class="text-center">
                        <a href="${base_url}admin/download/delete/${data}" class="btn btn-xs btn-danger">
                            <i class="fa fa-eye"></i> Delete
                        </a>
                        <a href="${base_url}admin/download/edit/${data}" class="btn btn-xs btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>`;
        }
      }
    ],
    order: [[5, "desc"]],
    rowId: function(a) {
      return a;
    },
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $("td:eq(1)", row).html(index);
    }
  });

  table
    .buttons()
    .container()
    .appendTo("#download_wrapper .col-md-6:eq(0)");

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

  $("#download tbody").on("click", "tr .check", function() {
    var check = $("#download tbody tr .check").length;
    var checked = $("#download tbody tr .check:checked").length;
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
            text: respon.total + " data berhasil dihapus",
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