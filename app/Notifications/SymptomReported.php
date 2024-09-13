<?php

namespace App\Notifications;

use App\Models\PatientSymptom;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidMessagePriority;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;

class SymptomReported extends Notification
{
    use Queueable;

    public PatientSymptom $patientSymptom;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PatientSymptom $patientSymptom)
    {
        $this->patientSymptom = $patientSymptom;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database','broadcast',PusherChannel::class,FcmChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        $data = $this->patientSymptom->toArray();
        $data['notification_message'] = "{$data['assistant_nurse']['full_name']} reported that {$data['patient']['full_name']} has {$data['symptom']['name']}";
        return $data;
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->patientSymptom->toArray());
    }

    public function toPushNotification($notifiable)
    {
        $data = $this->toArray($notifiable);
        return PusherMessage::create()->web()->title('Reported New Symptom')
            ->body($data['notification_message'])->setOption('data',$data);
    }

    public function toFcm($notifiable)
    {
        $data = $this->toArray($notifiable);
        return FcmMessage::create()
            ->setNotification(
                \NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Reported new Symptom')
                    ->setBody($data['notification_message'])
            )
            ->setData([
                'data' => json_encode($data),
                'type' => 'SymptomReported',
            ])
            ->setAndroid(
                AndroidConfig::create()->setNotification(
                    AndroidNotification::create()->setColor('#A24B90')->setIcon('ic_launcher')
                        ->setSound('default')
                )->setPriority(AndroidMessagePriority::HIGH)
            );
    }
}
