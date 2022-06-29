<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailService extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $LstData = [];
    public $StrAsunto = "";
    public $StrVista = "";
    public $StrPara = "";

    public function __construct($StrAsunto, $LstData, $StrVista)
    {
        $this->StrAsunto = $StrAsunto;
        $this->LstData = $LstData;
        $this->StrVista = $StrVista;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->StrVista)
                    ->from("ventanilla-noreplay@chihuahua.gob.mx", env('MAIL_FROM_NAME'))
                    ->subject($this->StrAsunto)
                    ->with($this->LstData);
    }
}
