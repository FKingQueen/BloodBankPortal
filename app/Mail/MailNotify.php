<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;
    public $validate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($validate)
    {
        $this->validate = $validate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->validate == 0){
            return $this->from('bbnegrosoriental@gmail.com', 'Blood Bank Negros Oriental Hospital')->view('mail/approvedRegistration');
        }else if($this->validate == 1){
            return $this->from('bbnegrosoriental@gmail.com', 'Blood Bank Negros Oriental Hospital')->view('mail/newChat');
        }
        
    }
}
