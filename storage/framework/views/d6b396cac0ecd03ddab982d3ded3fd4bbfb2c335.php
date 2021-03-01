<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'payer','method'=>'post'))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('payer_name',__('Payer Name'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('payer_name',null,array('class'=>'form-control','placeholder'=>__('Enter Payer Name')))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('contact_number',__('Contact Number'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::number('contact_number',null,array('class'=>'form-control','placeholder'=>__('Enter Contact Number')))); ?>

            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/payer/create.blade.php ENDPATH**/ ?>