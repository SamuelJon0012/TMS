<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EncounterProcedureResult extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.EncounterProcedureResult');
    }
}
