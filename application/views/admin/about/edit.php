<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/about/save', array('id' => 'formabout'), array('method' => 'edit', 'about_id' => $about->about_id)); ?>
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
                                <input type="hidden" name="about_id" class="form-control" value="<?= $about->about_id ?>">
                                <label for="about" class="control-label text-center">Title</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="title" class="form-control" value="<?= $about->title ?>">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('title') ?></small>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12">

                                <label for="about" class="control-label text-center">Header</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="header" class="form-control" value="<?= $about->header ?>">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('header') ?></small>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12">

                                <label for="about" class="control-label text-center">Link</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="link" class="form-control" value="<?= $about->link ?>">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('link') ?></small>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label for="about" class="control-label text-center">Photo</label>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <input type="file" name="file_about" class="form-control">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('file_about') ?></small>
                                        <?php if (!empty($about->photo)) : ?>
                                            <?= tampil_media('uploads/about/' . $about->photo); ?>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?= base_url('admin/about') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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