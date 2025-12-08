<?php

namespace App\Listeners;

use App\Events\SchoolApproved;
use App\Enums\UserRole;
use App\Mail\SchoolApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSchoolApprovedNotification implements ShouldQueue
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
    public function handle(SchoolApproved $event): void
    {
        $school = $event->school;
        
        // Find the admin/operator for this school
        if ($school->admin) {
            Mail::to($school->admin->email)->send(new SchoolApprovedNotification($school));
        }
    }
}
