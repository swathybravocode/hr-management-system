<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class PayslipSend extends Mailable
{
    use Queueable, SerializesModels;

    public $payslip;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payslip)
    {
        $this->payslip = $payslip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.payslip_send')->with('payslip', $this->payslip)->subject('Ragarding to payslip generator.');
    }
}
