<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'transfer','method'=>'post'))); ?>

    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('employee_code', __('Employee Code'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('employee_code', null, array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-lg-4 col-md-4">
            <?php echo e(Form::label('branch_id',__('Branch'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('branch_id',$branches,null,array('class'=>'form-control select2'))); ?>

        </div>
        <div class="form-group col-lg-4 col-md-4">
            <?php echo e(Form::label('department_id',__('Department'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::select('department_id',$departments,null,array('class'=>'form-control select2'))); ?>

        </div>
        <div class="form-group col-lg-4 col-md-4">
            <?php echo e(Form::label('transfer_date',__('Transfer Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('transfer_date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-lg-12">
            <?php echo e(Form::label('description',__('Description'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/transfer/create.blade.php ENDPATH**/ ?>