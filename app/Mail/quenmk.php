<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class quenmk extends Mailable
{
    use Queueable, SerializesModels;
    public $dataEmail;
 
    public function __construct($dataEmail)
    {
        //
        $this->dataEmail = $dataEmail;
    }

  
    public function build()
    {
        return $this->from('vanliken1@gmail.com', 'CongTyVanNe')
            ->subject('Mail xác nhận quên mật khẩu')
            ->markdown('clients.home.mailquenmk')
            ->with(['data' => $this->dataEmail]);
    }
}
