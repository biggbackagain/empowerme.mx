<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public Event $event;
    public User $user;
    public string $code;

    public function __construct(Event $event, User $user, string $code)
    {
        $this->event = $event;
        $this->user = $user;
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Tu código para ' . $this->event->title . ' — EmpowerMe')
            ->view('emails.event_ticket');
    }
}
