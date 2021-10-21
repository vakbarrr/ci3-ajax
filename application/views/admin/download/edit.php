<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/download/save', array('id' => 'formdownload'), array('method' => 'edit', 'download_id' => $download->download_id)); ?>
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
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="download_id" class="form-control" value="<?= $download->download_id ?>">
                                <label for="download" class="control-label text-center">Title</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="title" class="form-control" value="<?= $download->title ?>">
                                        <small class="help-block"></small>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label for="download" class="control-label text-center">File</label>
                                <input type="text" value="<?= $download->file ?>" class="form-control">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="file" name="file_download" class="form-control">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('file_download') ?></small>
                                        <input type="hidden" name="file_download" value="<?= base_url("uploads/download/ . $download->file")?>">
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?= base_url('admin/download') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>

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