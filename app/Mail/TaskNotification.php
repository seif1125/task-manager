<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $message;

    /**
     * Create a new message instance.
     */
    public function __construct(Task $task, $message)
    {
        $this->task = $task;
        $this->message = $message;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Task Notification')
                    ->view('emails.task-notification');
    }
}
