<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Warning')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Warning')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('warning.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Warning')); ?>">
                <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

            </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable" >
                            <thead>
                            <tr>
                                <th><?php echo e(__('Warning By')); ?></th>
                                <th><?php echo e(__('Warning To')); ?></th>
                                <th><?php echo e(__('Subject')); ?></th>
                                <th><?php echo e(__('Warning Date')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <?php if(Gate::check('Edit Warning') || Gate::check('Delete Warning')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $warnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty( $warning->WarningBy($warning->warning_by))? $warning->WarningBy($warning->warning_by)->name:''); ?></td>
                                    <td><?php echo e(!empty($warning->warningTo($warning->warning_to))?$warning->warningTo($warning->warning_to)->name:''); ?></td>
                                    <td><?php echo e($warning->subject); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($warning->warning_date)); ?></td>
                                    <td><?php echo e($warning->description); ?></td>
                                    <?php if(Gate::check('Edit Warning') || Gate::check('Delete Warning')): ?>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Warning')): ?>
                                                <a href="#" data-url="<?php echo e(URL::to('warning/'.$warning->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Warning')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Warning')): ?>
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($warning->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['warning.destroy', $warning->id],'id'=>'delete-form-'.$warning->id]); ?>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/warning/index.blade.php ENDPATH**/ ?>