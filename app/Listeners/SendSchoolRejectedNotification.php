<?php

namespace App\Listeners;

use App\Events\SchoolRejected;
use App\Mail\SchoolRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSchoolRejectedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SchoolRejected $event): void
    {
        $school = $event->school;
        
        if ($school->admin) {
            Mail::to($school->admin->email)->send(new SchoolRejectedNotification($school, $event->reason));
        }
    }
}
