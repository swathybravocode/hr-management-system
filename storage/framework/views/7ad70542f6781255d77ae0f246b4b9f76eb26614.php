<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Upload Employee Data')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <form method="post" action="<?php echo e(route('employee.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card ">
                <div class="card-header"><h6 class="mb-0"><?php echo e(__('Personal Detail')); ?></h6></div>
                <div class="card-body ">

                    <div class="form-group">
                        <?php echo Form::label('address', __('Address'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                        <?php echo Form::textarea('address',old('address'), ['class' => 'form-control','rows'=>2]); ?>

                    </div>
                    <div class="form-group">
                        <div class="float-left col-4">
                            <label for="document" class="float-left pt-1 form-control-label">Photo <span class="text-danger">*</span> </label>
                        </div>
                        <div class="float-right col-8">
                            <input type="hidden" name="emp_photo" id="" value="">
                            <div class="choose-file form-group">
                                <label for="document">
                                    <div><?php echo e(__('Choose File')); ?></div>
                                    <input class="form-control border-0"  required name="employee_photo" type="file" id="employee_photo" data-filename="<?php echo e('_filename'); ?>">
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