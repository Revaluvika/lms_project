<?php

namespace App\Listeners;

use App\Events\NewSchoolRegistered;
use App\Enums\UserRole;
use App\Mail\NewSchoolRegistrationNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewSchoolNotification implements ShouldQueue
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
    public function handle(NewSchoolRegistered $event): void
    {
        $dinasAdmins = User::where('role', UserRole::ADMIN_DINAS)->get();
        foreach ($dinasAdmins as $index => $admin) {
            $delay = now()->addSeconds(($index + 1) * 5);
            Mail::to($admin->email)->later($delay, new NewSchoolRegistrationNotification($event->school));
        }
    }
}
