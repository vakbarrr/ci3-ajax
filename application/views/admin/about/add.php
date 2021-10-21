<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/about/save', array('id' => 'formabout'), array('method' => 'add')); ?>
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
                                <small class="help-block" style="color: #dc3545"><?= form_error('title') ?></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="title" class="control-label">Header</label>
                            <div class="form-group">
                                <input type="text" name="header" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('header') ?></small>
                            </div>
                        </div>
                       
                        <div class="col-sm-12">
                            <label for="title" class="control-label">Link</label>
                            <div class="form-group">
                                <input type="text" name="link" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('link') ?></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="photo" class="control-label">Photo</label>
                            <div class="form-group">
                                <input type="file" name="file_about" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('file_about') ?></small>
                            </div>
                        </div>


                        <div class="form-group pull-right">
                            <a href="<?= base_url('admin/about') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>