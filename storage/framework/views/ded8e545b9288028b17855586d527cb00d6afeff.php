<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'appraisal','method'=>'post'))); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('branch',__('Branch'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('branch',$brances,null,array('class'=>'form-control select2','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('employee',__('Employee'),['class'=>'form-control-label'])); ?>

                <select class="select2 form-control select2-multiple" id="employee" name="employee" data-toggle="select2" data-placeholder="<?php echo e(__('Select Employee')); ?>" required>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('appraisal_date',__('Select Month'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('appraisal_date','', array('class' => 'form-control custom-datepicker'))); ?>

            </div>
        </div>
        <div class="col-md-12 mt-3">
            <h6><?php echo e(__('Technical Competencies')); ?></h6>
            <hr class="mt-0">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('customer_experience',__('Customer Experience'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('customer_experience',$technical,null,array('class'=>'form-control select2'))); ?>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('marketing',__('Marketing'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('marketing',$technical,null,array('class'=>'form-control select2'))); ?>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('administration',__('Administration'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('administration',$technical,null,array('class'=>'form-control select2'))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-3">
            <h6><?php echo e(__('Organizational Competencies')); ?></h6>
            <hr class="mt-0">
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('professionalism',__('Professionalism'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('professionalism',$organizational,null,array('class'=>'form-control select2'))); ?>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('integrity',__('Integrity'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('integrity',$organizational,null,array('class'=>'form-control select2'))); ?>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('attendance',__('Attendance'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::select('attendance',$organizational,null,array('class'=>'form-control select2'))); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('remark',__('Remarks'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::textarea('remark',null,array('class'=>'form-control'))); ?>

            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/appraisal/create.blade.php ENDPATH**/ ?>