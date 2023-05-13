<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadoEnviadaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $titulo;
    protected $estudiante;
    protected $cod_matricula;

    public function __construct($titulo,$estudiante,$cod_matricula)
    {
        $this->titulo = $titulo;
        $this->estudiante = $estudiante;
        $this->cod_matricula = $cod_matricula;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.estado_enviado_mail')
                        ->with(
                            [
                                "titulo" => $this->titulo,
                                "estudiante" => $this->estudiante,
                                "cod_matricula" => $this->cod_matricula,
                            ]
                        );
    }
}
