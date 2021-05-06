<div class="card bg-none card-box">
    <?php echo e(Form::model($document,array('route' => array('document.update', $document->id), 'method' => 'PUT'))); ?>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('name',__('Name',['class'=>'form-control-label']))); ?>

                <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Department Name')))); ?>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('is_required', __('Required Field'),['class'=>'form-control-label'])); ?>

                <select class="form-control select2" required name="is_required">
                    <option value="0" <?php if($document->is_required == 0): ?> selected <?php endif; ?>><?php echo e(__('Not Required')); ?></option>
                    <option value="1" <?php if($document->is_required == 1): ?> selected <?php endif; ?>><?php echo e(__('Is Required')); ?></option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/document/edit.blade.php ENDPATH**/ ?>