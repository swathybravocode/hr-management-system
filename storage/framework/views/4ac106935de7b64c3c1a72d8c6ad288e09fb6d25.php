<div class="card bg-none card-box">
    <?php echo e(Form::model($holiday, array('route' => array('holiday.update', $holiday->id), 'method' => 'PUT'))); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('date',__('Date'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('date',null,array('class'=>'form-control datepicker'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('occasion',__('Occasion'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('occasion',null,array('class'=>'form-control'))); ?>

        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<script>
    if ($(".datepicker").length) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            format: 'yyyy-mm-dd',
            locale: date_picker_locale,
        });
    }
</script>
<?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/holiday/edit.blade.php ENDPATH**/ ?>