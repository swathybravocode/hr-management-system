<?php
    $logo=asset(Storage::url('uploads/logo/'));
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Forgot Password')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="login-contain">
        <div class="login-inner-contain">
            <a class="navbar-brand" href="#">
                <img src="<?php echo e($logo.'/logo.png'); ?>" class="navbar-brand-img" alt="logo">
            </a>
            <div class="login-form">
                <div class="page-title"><h5><?php echo e(__('Reset Password')); ?></h5></div>
                <?php echo e(Form::open(array('route'=>'password.update','method'=>'post','id'=>'loginForm'))); ?>

                <input type="hidden" name="token" value="<?php echo e($token); ?>">
                <div class="form-group">
                    <?php echo e(Form::label('email',__('E-Mail Address'),['class'=>'form-control-label'])); ?>

                    <?php echo e(Form::text('email',null,array('class'=>'form-control'))); ?>

                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-email text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('password',__('Password'),['class'=>'form-control-label'])); ?>

                    <?php echo e(Form::password('password',array('class'=>'form-control'))); ?>

                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-password text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <?php echo e(Form::label('password_confirmation',__('Password Confirmation'),['class'=>'form-control-label'])); ?>

                    <?php echo e(Form::password('password_confirmation',array('class'=>'form-control'))); ?>

                    <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-password_confirmation text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <?php echo e(Form::submit(__('Reset Password'),array('class'=>'btn-login','id'=>'resetBtn'))); ?>

                <?php echo e(Form::close()); ?>

            </div>
            <h5 class="copyright-text">
                <?php echo e((Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright HRMGo')); ?> <?php echo e(date('Y')); ?>

            </h5>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/auth/passwords/reset.blade.php ENDPATH**/ ?>