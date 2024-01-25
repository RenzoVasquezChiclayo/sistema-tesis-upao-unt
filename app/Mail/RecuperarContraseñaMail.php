<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarContraseñaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $nombres;
    protected $url;
    public function __construct($nombres,$url)
    {
        $this->nombres = $nombres;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.login.recuperar_contraseña')->with([
            "nombres" => $this->nombres,
            "url" => $this->url
        ]);
    }
}
