<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/cornerstones/save', array('id' => 'formcornerstones'), array('method' => 'edit', 'cornerstones_id' => $cornerstones->cornerstones_id)); ?>
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
                                <input type="hidden" name="cornerstones_id" class="form-control" value="<?= $cornerstones->cornerstones_id ?>">
                                <label for="cornerstones" class="control-label text-center">Title</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="title" class="form-control" value="<?= $cornerstones->title ?>">
                                        <small class="help-block"></small>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label for="cornerstones" class="control-label text-center">Description</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="description" class="form-control" value="<?= $cornerstones->description ?>">
                                        <small class="help-block"></small>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label for="cornerstones" class="control-label text-center">Link</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="link" class="form-control" value="<?= $cornerstones->link ?>">
                                        <small class="help-block"></small>
                                    </div>

                                </div>
                            </div>


                            <div class="col-sm-12">
                                <label for="soal" class="control-label text-center">Photo</label>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <input type="file" name="photo" class="form-control">
                                        <small class="help-block"></small>
                                        <?php if (!empty($cornerstones->photo)) : ?>
                                            <?= tampil_media('uploads/cornerstones/' . $cornerstones->photo); ?>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="form-group col-sm-9">
                                        <img src="<?= base_url('uploads/cornerstones/' . $cornerstones->photo)?>" alt="">
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?= base_url('admin/cornerstones') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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
        $('#formcornerstones').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var btn = $('#submit');

            btn.attr('disabled', 'disabled').text('Wait...');

            $.ajax({
                url: $(this).attr('action'),
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(this),
                type: 'POST',
                success: function(response) {
                    btn.removeAttr('disabled').text('Update');
                    if (response.status) {
                        Swal('Sukses', 'Data Berhasil diupdate', 'success')
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