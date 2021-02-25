<?php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
?>
<style>
    address{text-align: justify;}
    address span{float: right;}
    table { border: 2px solid #ccc; }
    #payslip-table{ border-radius: 5px; }
</style>
<div class="card bg-none card-box">
    <div class="text-md-right mb-2">
        <a href="#" class="btn btn-xs rounded-pill btn-warning" onclick="saveAsPDF()"><span class="fa fa-download"></span></a>
        <a title="Mail Send" href="<?php echo e(route('payslip.send',[$employee->id,$payslip->salary_month])); ?>" class="btn btn-xs rounded-pill btn-primary"><span class="fa fa-paper-plane"></span></a>
    </div>
    <div class="invoice" id="printableArea">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h6 class="mb-3"><?php echo e(__('Payslip')); ?></h6>
                        <div class="invoice-number">
                            <img src="<?php echo e($logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')); ?>" width="170px;">
                        </div>
                    </div>
                    <hr>
                    <div class="row text-sm">
                        <div class="col-md-7">
                            <address>
                                <strong><?php echo e(__('Name')); ?> &emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>&emsp;&emsp; <?php echo e($employee->name); ?><br>
                                <strong><?php echo e(__('Division')); ?>&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp; :</strong>&emsp;&emsp; <?php echo e($employee->department->name); ?><br>
                                
                                <strong><?php echo e(__('Bank Details')); ?>&nbsp;&nbsp; :</strong>&emsp;&emsp; <?php echo e(('A/C # -')); ?> <?php echo e($employee->account_number); ?><br> 
                                <strong>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</strong>&emsp;&emsp; <?php echo e($employee->bank_name); ?>


                            </address>
                        </div>
                        <div class="col-md-5 text-md-right">
                            <address>                                
                                <strong><?php echo e(__('Pay Slip')); ?> &emsp;&emsp;&emsp;&emsp;&nbsp;:</strong><span> <?php echo e(\Auth::user()->dateFormat( $payslip->salary_month)); ?></span><br>
                                <strong><?php echo e(__('Employee Code')); ?>&nbsp; :</strong> <span><?php echo e($employee->employee_code); ?></span><br>
                                <strong><?php echo e(__('Region')); ?>&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:</strong> <span><?php echo e($employee->branch->name); ?></span><br>
                                <strong><?php echo e(__('Currency')); ?>&emsp;&emsp;&emsp;&nbsp;&nbsp; :</strong> <span><?php echo e(__('INR')); ?></span><br>
                            
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div id="payslip-table" class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <tbody>
                            <tr class="font-weight-bold">
                                <th><?php echo e(__('Earning')); ?></th>
                                <th><?php echo e(__('Amount')); ?></th>                                
                            </tr>
                            <tr>
                                <td><?php echo e(__('Basic Salary')); ?></td>
                                <td><?php echo e(\Auth::user()->priceFormat( $payslip->basic_salary)); ?></td>
                            </tr>
                            <?php $__currentLoopData = $payslipDetail['earning']['allowance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($allowance->title); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat( $allowance->amount)); ?></td>                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $payslipDetail['earning']['commission']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($commission->title); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat( $commission->amount)); ?></td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $payslipDetail['earning']['otherPayment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($otherPayment->title); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat( $otherPayment->amount)); ?></td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $payslipDetail['earning']['overTime']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overTime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($overTime->title); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat( $overTime->amount)); ?></td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(__('Total Earning')); ?></td>
                                <td><?php echo e(\Auth::user()->priceFormat($payslipDetail['totalEarning'])); ?></td>
                                
                            </tr>
                            <tr>
                                <td><?php echo e(__('Net Salary')); ?></td>
                                <td><?php echo e(\Auth::user()->priceFormat($payslip->net_payble)); ?></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div id="payslip-table" class="table-responsive">
                        <table class="table table-striped table-hover table-md" >
                            <tbody>
                            <tr class="font-weight-bold">
                                <th><?php echo e(__('Deduction')); ?></th>
                                 
                                <th class="text-right"><?php echo e(__('Amount')); ?></th>
                            </tr>

                            <?php $__currentLoopData = $payslipDetail['deduction']['loan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loan->title); ?></td>
                                     
                                    <td class="text-right"><?php echo e(\Auth::user()->priceFormat( $loan->amount)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $payslipDetail['deduction']['deduction']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($deduction->title); ?></td>
                                    
                                    <td class="text-right"><?php echo e(\Auth::user()->priceFormat( $deduction->amount)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                    
                
            </div>

            
        </div>
        <hr>
        <div class="text-md-left pb-2 text-sm">
             
            <p class="mt-2 small"> <?php echo e(__('Variable Compensation is paid at the discretion of the management and does not constitute, as part of guaranteed compensation')); ?></p>
        <p class="small"><?php echo e(__('This is a computer generated document and does not require a signature. This document may not be used for the purpose of obtaining a credit card.')); ?></p>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
<script>

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: '<?php echo e($employee->name); ?>',
            image: {type: 'jpeg', quality: 1},
            html2canvas: {scale: 4, dpi: 72, letterRendering: true},
            jsPDF: {unit: 'in', format: 'A4'}
        };
        html2pdf().set(opt).from(element).save();
    }

</script>
<?php /**PATH C:\xampp\htdocs\EysysHRM_Code\resources\views/payslip/pdf.blade.php ENDPATH**/ ?>