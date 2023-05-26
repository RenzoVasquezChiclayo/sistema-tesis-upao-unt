<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadoObservadoTesisMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $asesor;
    protected $titulo;
    public function __construct($titulo,$asesor)
    {
        $this->asesor = $asesor;
        $this->titulo = $titulo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.estado_observado_tesis_mail')
                        ->with(
                            [
                                "titulo" => $this->titulo,
                                "asesor" => $this->asesor
                            ]
                        );
    }
}
