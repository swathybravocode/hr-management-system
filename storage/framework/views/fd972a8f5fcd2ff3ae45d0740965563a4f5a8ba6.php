<div class="card bg-none card-box">
    <?php echo e(Form::model($loan,array('route' => array('loan.update', $loan->id), 'method' => 'PUT'))); ?>

    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('title', __('Title'))); ?>

                    <?php echo e(Form::text('title',null, array('class' => 'form-control ','required'=>'required'))); ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('loan_option', __('Loan Options*'))); ?>

                    <?php echo e(Form::select('loan_option',$loan_options,null, array('class' => 'form-control select2','required'=>'required'))); ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('amount', __('Loan Amount'))); ?>

                    <?php echo e(Form::number('amount',null, array('class' => 'form-control ','required'=>'required'))); ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('start_date', __('Start Date'))); ?>

                    <?php echo e(Form::text('start_date',null, array('class' => 'form-control datepicker','required'=>'required'))); ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo e(Form::label('end_date', __('End Date'))); ?>

                    <?php echo e(Form::text('end_date',null, array('class' => 'form-control datepicker','required'=>'required'))); ?>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('reason', __('Reason'))); ?>

                    <?php echo e(Form::textarea('reason',null, array('class' => 'form-control ','required'=>'required'))); ?>

                </div>
            </div>
            <div class="col-12">
                <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
                <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
            </div>
        </div>

    </div>
    <?php echo e(Form::close()); ?>

</div>

<?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/loan/edit.blade.php ENDPATH**/ ?>