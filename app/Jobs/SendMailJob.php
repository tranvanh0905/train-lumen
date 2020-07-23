<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob extends Job implements ShouldQueue {

    use InteractsWithQueue, SerializesModels;

    protected $task;

    public function __construct(Task $task) {
        $this->task = $task;
    }

    public function handle(Mailer $mailer) {
        $mailer->send('email.email', [], function($message) {
            $message->to('tranvanh0905@gmail.com', 'AC')->subject('Welcome');
        });
    }
}
