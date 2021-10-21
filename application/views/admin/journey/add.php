<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/journey/save', array('id' => 'formjourney'), array('method' => 'add')); ?>
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
                            <input type="text" class="form-control" name="journey_title" id="journey_title" placeholder="Title">
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group">
                            <label for="photo" class="control-label">Content</label>
                            <textarea name="journey_content" id="mytextarea" cols="30" rows="10"></textarea>
                            <small class="help-block"></small>
                        </div>
                        <!-- <div class="form-group">
                            <label for="qualification" class="control-label">Content</label>
                            <textarea name="journey_content" id="journey_content" class="form-control froala-editor"></textarea>
                            <small class="help-block"></small>
                        </div> -->

                        <div class="form-group">
                            <label for="title">Date</label>
                            <input type="date" class="form-control" name="journey_date" id="journey_date" placeholder="Link">
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group">
                            <label for="title">Photo</label>
                            <input type="file" class="form-control" name="photo" placeholder="photo">
                            <small class="help-block"></small>
                        </div>


                        <div class="form-group pull-right">
                            <a href="<?= base_url('admin/journey') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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
        $('#formjourney').on('submit', function(e) {
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
                                    window.location.href = base_url + 'admin/journey';
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

        $('#formjourney input, #formjourney select').on('change', function() {
            $(this).closest('.form-group').removeClass('has-error has-success');
            $(this).nextAll('.help-block').eq(0).text('');
        });
    });
</script>