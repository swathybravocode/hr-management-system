<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo e(asset(Storage::url('uploads/logo')).'/favicon.png'); ?>" type="image" sizes="16x16">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e((Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'HRMGo')); ?> - <?php echo $__env->yieldContent('page-title'); ?></title>

    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css')); ?>">
    <!-- Purpose CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/purpose.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/ac.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/stylesheet.css')); ?>">
</head>
<body>

<?php echo $__env->yieldContent('content'); ?>

<script src="<?php echo e(asset('assets/libs/jquery/dist/jquery.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/layouts/auth.blade.php ENDPATH**/ ?>