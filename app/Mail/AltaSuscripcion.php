<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AltaSuscripcion extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $movil;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $movil)
    {
        $this->email = $email;
        $this->movil = $movil;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'admin@mtcapp.com';
        $name = 'App Muevete 3 Cantos';
        $subject = 'Solicitud Alta Casa de la Juventud';

        return $this->view('emails.alta')
            ->from($address, $name)
            ->subject($subject)        
            ->with(['email'=>$this->email, 'movil'=>$this->movil]);
    }
}
