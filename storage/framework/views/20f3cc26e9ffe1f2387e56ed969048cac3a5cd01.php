<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Managers')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Employee')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="<?php echo e(route('manager.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Manager Id')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Designation')); ?></th>
                                <?php if(Gate::check('Edit Employee') || Gate::check('Delete Employee')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="Id">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Employee')): ?>
                                            <a href="<?php echo e(route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>"><?php echo e(\Auth::user()->managerIdFormat($employee->manager_id)); ?></a>
                                        <?php else: ?>
                                            <a href="#"><?php echo e(\Auth::user()->managerIdFormat($employee->manager_id)); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="font-style"><?php echo e(!empty(\Auth::user()->getBranch($employee->manager_branch_id ))?\Auth::user()->getBranch($employee->manager_branch_id )->name:''); ?></td>

                                    <td class="font-style"><?php echo e($employee->manager_name); ?></td>
                                    <td><?php echo e($employee->manager_email); ?></td>
                                    
                                    <td class="font-style"><?php echo e(!empty(\Auth::user()->getDepartment($employee->manager_department_id ))?\Auth::user()->getDepartment($employee->manager_department_id )->name:''); ?></td>
                                    <td class="font-style"><?php echo e(!empty(\Auth::user()->getDesignation($employee->manager_type))?\Auth::user()->getDesignation($employee->manager_type )->name:''); ?></td>

                                    <?php if(Gate::check('Edit Employee') || Gate::check('Delete Employee')): ?>
                                        <td>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Employee')): ?>
                                                    <a href="<?php echo e(route('manager.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->manager_id))); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Employee')): ?>
                                                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($employee->manager_id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->manager_id],'id'=>'delete-form-'.$employee->manager_id]); ?>

                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/manager/index.blade.php ENDPATH**/ ?>