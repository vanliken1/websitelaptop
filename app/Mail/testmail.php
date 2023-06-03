<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class testmail extends Mailable
{
    use Queueable, SerializesModels;
    public $dataEmail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataEmail)
    {
        $this->dataEmail = $dataEmail;
    }




    public function build()
    {
        return $this->from('vanliken1@gmail.com', 'CongTyVanNe')
            ->subject('Gửi mail')
            ->markdown('clients.home.mail')
            ->with(['data' => $this->dataEmail]);
    }
}
