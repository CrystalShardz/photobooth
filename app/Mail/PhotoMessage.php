<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PhotoMessage extends Mailable
{
    use Queueable, SerializesModels;

    protected $photo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($photo)
    {
        $this->photo = $photo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email')
            ->subject('Your Photo Booth Picture')
            ->from('fishyfood566@gmail.com')
            ->attachFromStorageDisk('public', $this->photo)
            ->with('photo', $this->photo);
    }
}
