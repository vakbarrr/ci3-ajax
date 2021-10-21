<style>


textarea#mentions {
  height: 350px;
}

div.card,
.tox div.card {
  width: 240px;
  background: white;
  border: 1px solid #ccc;
  border-radius: 3px;
  box-shadow: 0 4px 8px 0 rgba(34, 47, 62, .1);
  padding: 8px;
  font-size: 14px;
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
}

div.card::after,
.tox div.card::after {
  content: "";
  clear: both;
  display: table;
}

div.card h1,
.tox div.card h1 {
  font-size: 14px;
  font-weight: bold;
  margin: 0 0 8px;
  padding: 0;
  line-height: normal;
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
}

div.card p,
.tox div.card p {
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
}

div.card img.avatar,
.tox div.card img.avatar {
  width: 48px;
  height: 48px;
  margin-right: 8px;
  float: left;
}


</style>
<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/download/save', array('id' => 'formdownload'), array('method' => 'add')); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $subjudul ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="col-sm-12">
                            <label for="title" class="control-label">Title</label>
                            <div class="form-group">
                                <input type="text" name="title" class="form-control">
                                <small class="help-block"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="photo" class="control-label">File</label>
                            <div class="form-group">
                                <input type="file" name="file_download" class="form-control">
                                <small class="help-block"></small>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <a href="<?= base_url('admin/download') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#formdownload').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let btn = $('#submit');
            // let form_data = new FormData();
            // var file_data = $('#file_download').val();
            btn.attr('disabled', 'disabled').text('Wait...');

            // form_data.append('file_download', file_data);
            $.ajax({
                url: $(this).attr('action'),
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(this),
                type: 'POST',
                success: function(response) {
                    btn.removeAttr('disabled').text('Simpan');
                    if (response.status) {
                        Swal('Sukses', 'Data Berhasil disimpan', 'success')
                            .then((result) => {
                                if (result.value) {
                                    window.location.href = base_url + 'admin/download';
                                }
                            });
                    } else {
                        $.each(response.errors, function(key, val) {
                            $('[name="' + key + '"]').closest('.form-group').addClass('has-error');
                            $('[name="' + key + '"]').nextAll('.help-block').eq(0).text(val);
                            if (val === '') {
                                $('[name="' + key + '"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                                $('[name="' + key + '"]').nextAll('.help-block').eq(0).text('');
                            }
                        });
                    }
                }
            })
        });

        $('#formdownload input, #formdownload select').on('change', function() {
            $(this).closest('.form-group').removeClass('has-error has-success');
            $(this).nextAll('.help-block').eq(0).text('');
        });
    });
</script>