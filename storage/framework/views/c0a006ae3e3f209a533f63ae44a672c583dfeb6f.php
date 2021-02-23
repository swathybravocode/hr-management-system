<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Manager')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::model($manager, array('route' => array('manager.update', $manager->manager_id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data'))); ?>

        <?php echo csrf_field(); ?>
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="card ">
                <div class="card-header"><h6 class="mb-0"><?php echo e(__('Personal Detail')); ?></h6></div>
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <?php echo Form::label('manager_name', __('First Name'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                            <?php echo Form::text('manager_name', $manager->manager_name, ['class' => 'form-control','required' => 'required']); ?>

                        </div>

                        <div class="form-group col-md-6">
                            <?php echo Form::label('manager_last_name', __('Last Name'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                            <?php echo Form::text('manager_last_name', $manager->manager_last_name, ['class' => 'form-control','required' => 'required']); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('manager_contact', __('Phone'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                            <?php echo Form::number('manager_contact',$manager->manager_contact, ['class' => 'form-control']); ?>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo Form::label('date_of_birth', __('Date of Birth'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                                <?php echo Form::text('date_of_birth', $manager->date_of_birth, ['class' => 'form-control datepicker']); ?>

                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="form-group ">
                                <?php echo Form::label('gender', __('Gender'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                                <div class="d-flex radio-check">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_male" value="Male" name="gender" class="custom-control-input" <?php echo e(($manager->gender == 'Male')?'checked':''); ?>>
                                        <label class="custom-control-label" for="g_male"><?php echo e(__('Male')); ?></label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="g_female" value="Female" name="gender" class="custom-control-input" <?php echo e(($manager->gender == 'Female')?'checked':''); ?>>
                                        <label class="custom-control-label" for="g_female"><?php echo e(__('Female')); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <?php echo Form::label('email', __('Email'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                            <?php echo Form::email('email', $manager->manager_email, ['class' => 'form-control','required' => 'required']); ?>

                        </div>

                    </div>
                    <div class="form-group">
                        <?php echo Form::label('address', __('Address'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
                        <?php echo Form::textarea('address', $manager->address, ['class' => 'form-control','rows'=>2]); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header"><h6 class="mb-0"><?php echo e(__('Company Detail')); ?></h6></div>
                <div class="card-body employee-detail-create-body">
                    <div class="row">
                        <?php echo csrf_field(); ?>



                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('branch_id', __('Branch'),['class'=>'form-control-label'])); ?>

                            <?php echo e(Form::select('branch_id', $branches, null, array('class' => 'form-control  select2','required'=>'required'))); ?>


                        </div>

                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('department_id', __('Department'),['class'=>'form-control-label'])); ?>

                            <?php echo e(Form::select('department_id', $departments,null, array('class' => 'form-control  select2','id'=>'department_id','required'=>'required'))); ?>

                        </div>


                        <div class="form-group col-md-12">
                            <?php echo e(Form::label('manager_type', __('Designation'),['class'=>'form-control-label'])); ?>

                            <select class="select2 form-control select2-multiple" id="manager_type" name="manager_type" data-toggle="select2" data-placeholder="<?php echo e(__('Select Designation ...')); ?>">
                                <option value=""><?php echo e(__('Select any Designation')); ?></option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(\Auth::user()->type != 'manager'): ?>
        <div class="row">
            <div class="col-12">
                <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create btn-xs badge-blue radius-10px float-right">
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>

<script type="text/javascript">

    function getDesignation(did) {
        $.ajax({
            url: '<?php echo e(route('manager.json')); ?>',
            type: 'POST',
            data: {
                "department_id": did, "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function (data) {
                $('#manager_type').empty();
                $('#manager_type').append('<option value="">Select any Designation</option>');
                $.each(data, function (key, value) {
                    var select = '';
                    if (key == '<?php echo e($manager->manager_type); ?>') {
                        select = 'selected';
                    }

                    $('#manager_type').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                });
            }
        });
    }

    $(document).ready(function () {
        var d_id = $('#department_id').val();
        var designation_id = '<?php echo e($manager->manager_type); ?>';
        getDesignation(d_id);
    });

    $(document).on('change', 'select[name=department_id]', function () {
        var department_id = $(this).val();
        getDesignation(department_id);
    });

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/manager/edit.blade.php ENDPATH**/ ?>