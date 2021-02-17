<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'company-policy','method'=>'post', 'enctype' => "multipart/form-data"))); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('branch',__('Branch'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('branch',$branch,null,array('class'=>'form-control select2','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('title',__('Title'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('title',null,array('class'=>'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('description', __('Description'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::textarea('description',null, array('class' => 'form-control'))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('attachment',__('Attachment'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::file('attachment',null,array('class'=>'form-control'))); ?>

                <small><?php echo e(__('Upload files only: gif,png,jpg,jpeg,pdf,doc')); ?></small>
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/companyPolicy/create.blade.php ENDPATH**/ ?>