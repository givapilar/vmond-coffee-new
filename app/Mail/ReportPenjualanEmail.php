<?php

namespace App\Mail;

use App\Models\OtherSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportPenjualanEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $updateStatus;

    public function __construct($updateStatus)
    {
        $this->updateStatus = $updateStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['dateNow'] = date('Y-m-d');
        $data['monthNow'] = date('Y-m');
        $data['yearNow'] = date('Y');

        $data['orders'] = $this->updateStatus;
        $data['otherSetting'] = OtherSetting::get();

        return $this->view('mail.send-mail', $data)->from('portfoliowebsite0505@gmail.com', 'Controlindo');
    }
}
