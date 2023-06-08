<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class xacnhandh extends Mailable
{
    use Queueable, SerializesModels;
    public $dataEmail1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataEmail1)
    {
        //
        $this->dataEmail1 = $dataEmail1;

    }

  

    public function build()
    {
        return $this->from('vanliken1@gmail.com', 'CongTyVanNe')
            ->subject('Gửi mail đã xác nhận đơn hàng')
            ->markdown('admin.mail.confirm-order')
            ->with(['data' => $this->dataEmail1]);
    }
}
