<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/cornerstones/save', array('id' => 'formcornerstones'), array('method' => 'add')); ?>
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

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group">
                            <label for="title">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="description" id="description">
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group">
                            <label for="title">Link</label>
                            <input type="text" class="form-control" name="link" id="link" placeholder="Link">
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group">
                            <label for="title">Photo</label>
                            <input type="file" class="form-control" name="photo" placeholder="photo">
                            <small class="help-block"></small>
                        </div>


                        <div class="form-group pull-right">
                            <a href="<?= base_url('admin/cornerstones') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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
        $('#formcornerstones').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let btn = $('#submit');

            btn.attr('disabled', 'disabled').text('Wait...');

    
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
                                    window.location.href = base_url + 'admin/cornerstones';
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

        $('#formcornerstones input, #formcornerstones select').on('change', function() {
            $(this).closest('.form-group').removeClass('has-error has-success');
            $(this).nextAll('.help-block').eq(0).text('');
        });
    });
</script>