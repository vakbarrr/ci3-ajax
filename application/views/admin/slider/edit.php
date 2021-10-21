<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('admin/slider/save', array('id' => 'formslider'), array('method' => 'edit', 'slider_id' => $slider->slider_id)); ?>
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
                                <input type="hidden" name="slider_id" class="form-control" value="<?= $slider->slider_id ?>">
                                <label for="slider" class="control-label text-center">Title</label>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <input type="text" name="title" class="form-control" value="<?= $slider->title ?>">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('text') ?></small>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label for="slider" class="control-label text-center">Photo</label>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <input type="file" name="file_slider" class="form-control">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('file_slider') ?></small>
                                        <?php if (!empty($slider->photo)) : ?>
                                            <?= tampil_media('uploads/slider/' . $slider->photo); ?>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?= base_url('admin/slider') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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