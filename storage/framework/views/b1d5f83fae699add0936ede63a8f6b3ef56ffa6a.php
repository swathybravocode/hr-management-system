<?php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
?>

<style>
    address{text-align: justify;}
   address span{float: right;}

    #payslip-table{ border-radius: 3px; }
   table.GeneratedTable {
 width: 100%;
 background-color: #ccc;
 border-collapse: collapse;
 border-width: 2px;
 border-color: #ccc;
 border-style: solid;
 color: rgb(156, 155, 155);
 text-align: left;

}

table.GeneratedTable td, table.GeneratedTable th {
 border-width: 2px;
 border-color: #ccc;
 border-style: solid;
 padding: 10px;
}

table.GeneratedTable thead {
 background-color: #ccc;
}
</style>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payslip')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="text-md-right mb-2">
            <a href="#" class="btn btn-warning" onclick="saveAsPDF()"><span class="fa fa-download"></span></a>
        </div>
        <div class="col-8">
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

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div id="payslip-table" class="table-responsive">
                                

                                <table class="GeneratedTable">
                                    <tr>
                                      <th scope="col" ><?php echo e(__('Earnings')); ?> <span style="float:right"><?php echo e(__('Amount')); ?></span></th>
                                      <th scope="col" ><?php echo e(__('Deductions')); ?> <span style="float:right"><?php echo e(__('Amount')); ?></span></th>
                                    </tr>
                                    <tr>
                                      <td>
                                      <p><?php echo e(__('Basic Salary')); ?> <span style="float:right"><?php echo e(\Auth::user()->priceFormat( $payslip->basic_salary)); ?></span></p>
                                      <?php $__currentLoopData = $payslipDetail['earning']['allowance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <p><?php echo e($allowance->title); ?> <span style="float:right"><?php echo e(\Auth::user()->priceFormat( $allowance->amount)); ?></span></p>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php $__currentLoopData = $payslipDetail['earning']['commission']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <p><?php echo e($commission->title); ?> <span style="float:right"><?php echo e(\Auth::user()->priceFormat( $commission->amount)); ?></span></p>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php $__currentLoopData = $payslipDetail['earning']['otherPayment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <p><?php echo e($otherPayment->title); ?> <span style="float:right"><?php echo e(\Auth::user()->priceFormat( $otherPayment->amount)); ?></span></p>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $payslipDetail['earning']['overTime']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overTime): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <p><?php echo e($overTime->title); ?> <span style="float:right"><?php echo e(\Auth::user()->priceFormat( $overTime->amount)); ?></span></p>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      <p><b><?php echo e(__('Total Earnings')); ?></b> <span style="float:right"><?php echo e(\Auth::user()->priceFormat($payslipDetail['totalEarning'])); ?></span></p>
                                      </td>
                                      <td>
                                      <?php $__currentLoopData = $payslipDetail['deduction']['loan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <p><?php echo e($loan->title); ?> <span style="float:right"><?php echo e(\Auth::user()->priceFormat( $loan->amount)); ?></span></p>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      <?php $__currentLoopData = $payslipDetail['deduction']['deduction']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <p><?php echo e($deduction->title); ?> <span style="float:right"><?php echo e(\Auth::user()->priceFormat( $deduction->amount)); ?></span></p>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      <p><span style="float:right"></span></p>
                                      <p><b>Total Deductions</b> <span style="float:right"><b><?php echo e(\Auth::user()->priceFormat($payslipDetail['totalDeduction'])); ?></b></span></p>
                                      </td>
                                    </tr>

                                    <tr>
                                      <td><b><?php echo e(__('Net Earnings')); ?></b> <span style="float:right;"><b><?php echo e(\Auth::user()->priceFormat($payslipDetail['netEarning'])); ?></b></span></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><p>Variable Compensation is paid at the discretion of the management and does not constitute, as part of guaranteed compensation</p>
                                      <p>This is a computer generated document and does not require a signature. This document may not be used for the purpose of obtaining a credit card.</p></td>
                                    </tr>
                                  </table>
                            </div>
                        </div>

                        


                    </div>


                </div>
                <hr>
                
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eysysco/public_html/hrms_demo/EysysHRM/resources/views/payslip/payslipPdf.blade.php ENDPATH**/ ?>