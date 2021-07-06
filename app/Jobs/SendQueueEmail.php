<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PayslipSend;
use App\Employee;
use Illuminate\Support\Facades\Crypt;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $payslip;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payslip)
    {
        $this->payslip = $payslip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $payslip = $this->payslip;

        $employee_info = Employee::find($payslip->employee_id);

        $payslip->name  = $employee_info->name;
        $payslip->email = $employee_info->email;
        $payslip->auth_password = $employee_info->auth_password;

        $payslipId    = Crypt::encrypt($payslip->id);
        $payslip->url = route('payslip.payslipPdf', $payslipId);

        try
        {
            Mail::to($payslip->email)->send(new PayslipSend($payslip));
        }
        catch(\Exception $e)
        {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        }

        // foreach($payslips as $payslip)
        // {
        //     Mail::to('reshmin.futura@gmail.com')->send(new PayslipSend($payslip));

        // }

    }
}
