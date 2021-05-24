<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Upload Employee Data')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <form method="post" action="<?php echo e(route('employee.upload.data')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card ">
                <div class="card-header"><h6 class="mb-0"><?php echo e(__('Choose Details')); ?></h6></div>
                <div class="card-body ">
                    <div class="row">
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('branch_id', __('Branch'),['class'=>'form-control-label'])); ?> <span class="text-danger">*</span>
                        <?php echo e(Form::select('branch_id', $branches, null, array('class' => 'form-control  select2','required'=>'required'))); ?>


                    </div>

                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('department_id', __('Department'),['class'=>'form-control-label'])); ?> <span class="text-danger">*</span>
                        <?php echo e(Form::select('department_id', $departments,null, array('class' => 'form-control  select2','id'=>'department_id','required'=>'required'))); ?>

                    </div>
                    </div>
                    <div class="form-group">
                        <div class="float-left col-4">
                            <label for="document" class="float-left pt-1 form-control-label">File (CSV) <span class="text-danger">*</span> </label>
                        </div>
                        <div class="float-right col-8">
                            <input type="hidden" name="emp_photo" id="" value="">
                            <div class="choose-file form-group">
                                <label for="document">
                                    <div><?php echo e(__('Choose File')); ?></div>
                                    <input class="form-control border-0"  required name="employee_data" type="file" id="employee_data" data-filename="<?php echo e('_filename'); ?>">
                                </label>
                                <p class="<?php echo e('_filename'); ?>"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <?php echo Form::submit('Upload', ['class' => 'btn btn-xs badge-blue float-right radius-10px']); ?>

            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>

    <script>

        $(function() {
  $('input[name="dob"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1940,
    maxYear: parseInt(moment().format('YYYY'),10),
    locale: {
      format: 'YYYY-MM-DD'
    }
  }, function(start, end, label) {

  });
});
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/employee/upload-page.blade.php ENDPATH**/ ?>