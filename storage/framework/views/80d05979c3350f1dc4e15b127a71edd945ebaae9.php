<?php (\App::setLocale( basename(App::getLocale()))); ?>
<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if($message->from_data): ?>
        <a href="<?php echo e(url('messages')); ?>" class="list-group-item list-group-item-action">

            <div class="d-flex align-items-center" data-toggle="tooltip" data-placement="right" data-title="2 hrs ago">
                <div>
                    <img alt="image" <?php if($message->from_data->avatar): ?> src="<?php echo e(asset('/storage/uploads/avatar/'.$message->from_data->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('storage/uploads/avatar/avatar.png')); ?>" <?php endif; ?> class="avatar rounded-circle"/>
                </div>
                <div class="flex-fill ml-3">
                    <div class="h6 text-sm mb-0"><?php echo e($message->from_data->name); ?> <small class="float-right text-muted"><?php echo e($message->created_at->diffForHumans()); ?></small></div>
                    <p class="text-sm lh-140 mb-0">
                        <?php echo $message->message; ?>

                    </p>
                </div>
            </div>
        </a>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/messenger/popup.blade.php ENDPATH**/ ?>