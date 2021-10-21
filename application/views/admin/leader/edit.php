<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/leader/save', array('id' => 'formleader'), array('method' => 'edit', 'leader_id' => $leader->leader_id)); ?>
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
                            <label for="title" class="control-label">Name</label>
                            <div class="form-group">
                                <input type="text" name="name" value="<?= $leader->name ?>" class="form-control">
                                <small class="help-block"></small>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="about" class="control-label">About</label>
                            <textarea name="about" id="basic-example" class="form-control"><?= $leader->about ?></textarea>
                            <small class="help-block"></small>
                        </div>


                        <div class="form-group col-sm-12">
                            <label for="qualification" class="control-label">Qualification</label>
                            <textarea name="qualification" id="basic-example1" class="form-control"><?= $leader->qualification ?></textarea>
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group  col-sm-12">
                            <label for="qualification" class="control-label">Relevant working</label>
                            <textarea name="relevant_working" id="basic-example2" class="form-control"><?= $leader->relevant_working ?></textarea>
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="qualification" class="control-label">Present director</label>
                            <textarea name="present_director" id="basic-example3" class="form-control"><?= $leader->present_director ?></textarea>
                            <small class="help-block"></small>
                        </div>

                        <div class="form-group col-sm-12">
                            <label>Grup leader</label>
                            <select name="grup_leaders" id="grup_leaders" class="select2 form-group" style="width:100% !important">
                                <option value="" disabled selected>Pilih Grup</option>
                                <option value="director">Director</option>
                                <option value="management">Management</option>
                            </select>
                            <small class="help-block"></small>
                        </div>
                        
                        <div class="col-sm-12">
                            <label for="photo" class="control-label">Photo</label>
                            <div class="form-group">
                                <input type="file" name="photo" class="form-control">
                                <small class="help-block"></small>
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
        $('#formleader').on('submit', function(e) {
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
                                    window.location.href = base_url + 'admin/leader';
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

        $('#formleader input, #formleader select').on('change', function() {
            $(this).closest('.form-group').removeClass('has-error has-success');
            $(this).nextAll('.help-block').eq(0).text('');
        });
    });
</script>