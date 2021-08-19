<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Contacto de Post';

    public $datos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //recibo los datos del form y los almaceno para enviarlo posteriormente por correo en la función build
        $this->datos = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //mando el correo con los datos que tiene la vista mailContent
        return $this->from('admin@post.com', 'Admin')
                ->view('mail.mailContent');
    }
}
