<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Message;

class huydh extends Mailable
{
    use Queueable, SerializesModels;
    public $dataEmail2;

    public function __construct($dataEmail2)
    {
        //
        $this->dataEmail2 = $dataEmail2;
    }

    public function build()
    {
       
        return $this->from('vanliken1@gmail.com', 'CongTyVanNe')
            ->subject('Thông báo hủy đơn hàng')
            ->markdown('admin.mail.destroy-order')
            ->with(['data' => $this->dataEmail2]);
    }
}
