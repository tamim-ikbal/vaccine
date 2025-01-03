<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;


class Verification extends Model
{
    use Notifiable;

    public function routeNotificationForMail(Notification $notification): array|string
    {
        // Return email address only...
        return $this->field;
    }

    public function routeNotificationForVonage(Notification $notification): string
    {
        return $this->field;
    }
}
