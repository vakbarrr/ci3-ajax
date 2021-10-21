<?= form_open('admin/award/save', array('id' => 'formaward'), array('method' => 'edit', 'award_id' => $data->award_id)); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form <?= $subjudul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>admin/award" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="email">Title</label>
                    <input type="text" class="form-control" name="title" value="<?= $data->title ?>" placeholder="Title of award">
                    <small class="help-block"></small>
                </div>

                <div class="form-group">
                    <label for="email">Year</label>
                    <input type="text" class="form-control" name="year" value="<?= $data->year ?>" placeholder="Year of award">
                    <small class="help-block"></small>
                </div>

                <div class="form-group">
                    <label for="email">Description</label>
                    <textarea name="description" id="description" class="form-control froala-editor"><?= set_value('description') ?><?= $data->description ?></textarea>
                    <small class="help-block"></small>
                </div>

                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple">
                        <i class="fa fa-pencil"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<script>
    $(document).ready(function() {
        $('#formaward').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var btn = $('#submit');

            btn.attr('disabled', 'disabled').text('Wait...');

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                type: 'POST',
                success: function(response) {
                    btn.removeAttr('disabled').text('Update');
                    if (response.status) {
                        Swal('Sukses', 'Data Berhasil diupdate', 'success')
                            .then((result) => {
                                if (result.value) {
                                    window.location.href = base_url + 'admin/award';
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

        $('#formaward input, #formaward select').on('change', function() {
            $(this).closest('.form-group').removeClass('has-error has-success');
            $(this).nextAll('.help-block').eq(0).text('');
        });
    });
</script>