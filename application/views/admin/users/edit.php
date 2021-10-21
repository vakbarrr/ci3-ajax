<div class="row">
    <?php if ($this->ion_auth->is_admin()) : ?>
        <div class="col-sm-12 mb-4">
            <a href="<?= base_url('admin/users') ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
        <div class="col-sm-4">
            <?= form_open('admin/users/edit_info', array('id' => 'user_info'), array('id' => $users->id)) ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Data User</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body pb-0">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $users->username ?>">
                        <small class="help-block"></small>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?= $users->first_name ?>">
                            <small class="help-block"></small>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?= $users->last_name ?>">
                            <small class="help-block"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $users->email ?>">
                        <small class="help-block"></small>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" id="btn-info" class="btn btn-info">Simpan</button>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    <?php endif; ?>
    <?php if ($user->id !== $users->id) : ?>
        <div class="col-sm-4">
            <?= form_open('admin/users/edit_level', array('id' => 'user_level'), array('id' => $users->id)) ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Level</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body pb-0">
                    <div class="form-group">
                        <label for="level">Level User</label>
                        <select id="level" name="level" class="form-control select2" style="width: 100%!important">
                            <option value="">Pilih Level</option>
                            <?php foreach ($groups as $row) : ?>
                                <option <?= $level->id === $row->id ? "selected" : "" ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="help-block"></small>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" id="btn-level" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <?= form_close() ?>

            <?= form_open('admin/users/edit_status', array('id' => 'user_status'), array('id' => $users->id)) ?>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Status</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body pb-0">
                    <div class="form-group">
                        <label>
                            <input <?= $users->active === '1' ? "checked" : "" ?> type="radio" name="status" value="1"> Aktif
                        </label>
                        <label>
                            <input <?= $users->active === '0' ? "checked" : "" ?> type="radio" name="status" value="0"> Tidak Aktif
                        </label>
                        <small class="help-block"></small>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" id="btn-status" class="btn btn-success">Simpan</button>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    <?php endif; ?>
    <?php if ($user->id === $users->id) : ?>
        <div class="col-sm-4">
            <?= form_open('admin/users/change_password', array('id' => 'change_password'), array('id' => $users->id)) ?>
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah Password</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body pb-0">
                    <div class="form-group">
                        <label for="old">Password Lama</label>
                        <input type="password" placeholder="Password Lama" name="old" class="form-control">
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="new">Password Baru</label>
                        <input type="password" placeholder="Password Baru" name="new" class="form-control">
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="new_confirm">Konfirmasi Password</label>
                        <input type="password" placeholder="Konfirmasi Password Baru" name="new_confirm" class="form-control">
                        <small class="help-block"></small>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" id="btn-pass" class="btn btn-flat btn-warning">Ganti Password</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function submitajax(url, data, msg, btn) {
        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            success: function(response) {
                if (response.status) {
                    Swal({
                        "title": "Berhasil",
                        "text": msg,
                        "type": "success"
                    });
                    $('form#change_password').trigger('reset');
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $('[name="' + key + '"]').closest('.form-group').addClass('has-error');
                            $('[name="' + key + '"]').nextAll('.help-block').eq(0).text(val);
                            if (val === '') {
                                $('[name="' + key + '"]').closest('.form-group').removeClass('has-error');
                                $('[name="' + key + '"]').nextAll('.help-block').eq(0).text('');
                            }
                        });
                    }
                    if (response.msg) {
                        Swal({
                            "title": "Gagal",
                            "text": "Password lama tidak benar",
                            "type": "error"
                        });
                    }
                }
                btn.removeAttr('disabled').text('Ganti Password');
            }
        });
    }

    $(document).ready(function() {
        $('form input, form select').on('change', function() {
            $(this).closest('.form-group').removeClass('has-error');
            $(this).nextAll('.help-block').eq(0).text('');
        });

        $('form#user_info').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            let btn = $('#btn-info');
            btn.attr('disabled', 'disabled').text('Process...');

            url = $(this).attr('action');
            data = $(this).serialize();
            msg = "Informasi user berhasil diupdate";
            submitajax(url, data, msg, btn);
        });

        $('form#user_level').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            let btn = $('#btn-level');
            btn.attr('disabled', 'disabled').text('Process...');

            url = $(this).attr('action');
            data = $(this).serialize();
            msg = "Level user berhasil diupdate";
            submitajax(url, data, msg, btn);
        });

        $('form#user_status').on('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            let btn = $('#btn-status');
            btn.attr('disabled', 'disabled').text('Process...');

            url = $(this).attr('action');
            data = $(this).serialize();
            msg = "Status user berhasil diupdate";
            submitajax(url, data, msg, btn);
        });

    });
</script>

<?php if ($user->id === $users->id) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('form#change_password').on('submit', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                let btn = $('#btn-pass');
                btn.attr('disabled', 'disabled').text('Process...');

                url = $(this).attr('action');
                data = $(this).serialize();
                msg = "Password anda berhasil diganti";
                submitajax(url, data, msg, btn);
            });
        });
    </script>
<?php endif; ?>