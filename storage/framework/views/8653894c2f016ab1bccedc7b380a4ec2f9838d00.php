<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url'=>'resignation/changeaction','method'=>'post'))); ?>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped mb-0 dataTable no-footer">
                <tr role="row">
                    <th><?php echo e(__('Employee')); ?></th>
                    <td><?php echo e(!empty($employee->name)?$employee->name:''); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Appplied On')); ?></th>
                    <td><?php echo e(\Auth::user()->dateFormat( $resignation->notice_date)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Resignation Date')); ?></th>
                    <td><?php echo e(\Auth::user()->dateFormat($resignation->resignation_date)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Resign Reason')); ?></th>
                    <td><?php echo e(!empty($resignation->description)?$resignation->description:''); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Status')); ?></th>
                    <td><?php echo e(!empty($resignation->status)?$resignation->status:''); ?></td>
                </tr>

                <input type="hidden" value="<?php echo e($resignation->id); ?>" name="resign_id">
            </table>
        </div>
        <div class="col-12">
            <input type="submit" class="btn-create badge-success" value="<?php echo e(__('Approval')); ?>" name="status">
            <input type="submit" class="btn-create bg-danger" value="<?php echo e(__('Reject')); ?>" name="status">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/resignation/action.blade.php ENDPATH**/ ?>