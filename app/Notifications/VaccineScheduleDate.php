<?php

namespace App\Notifications;

use App\Models\Dose;
use App\Models\VaccineCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use stdClass;

class VaccineScheduleDate extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public stdClass|VaccineCenter $vaccine_center,
        public Carbon $scheduleAt,
        public readonly null|stdClass|Dose $dose = null,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting(__('Hello :name', ['name' => $notifiable->name]))
            ->line('Congratulations! You got scheduled for COVID-19 vaccine.')
            ->line('')
            ->line(__('Vaccine Center: :center, :district', [
                'center'   => $this->vaccine_center->name,
                'district' => $this->vaccine_center->district
            ]))
            ->line(__('Nid: :nid', ['nid' => $notifiable->nid]))
            ->when($this->dose, fn($mail) => $mail->line(__('Dose: :dose', ['dose' => $this->dose->name])))
            ->line(__('Schedule At: :schedule_at', ['schedule_at' => $this->scheduleAt->format('d F Y h:i A')]))
            ->line('Thank you for register for the vaccine. Stay Safe!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
