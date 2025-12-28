<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    /**
     * Send notification to a notifiable entity
     */
    public function sendNotification(
        Model $notifiable,
        string $title,
        string $message,
        array $data = [],
        string $channel = 'push',
        string $type = 'general'
    ): Notification {
        return Notification::create([
            'type' => $type,
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'channel' => $channel,
            'status' => 'pending',
        ]);
    }

    /**
     * Send SMS notification (fallback)
     */
    public function sendSms($phone, $message)
    {
        // Integrate with SMS service
        // This would use the existing SMS service
        // For now, just log it
        \Log::info("SMS to {$phone}: {$message}");
    }

    /**
     * Send push notification
     */
    public function sendPushNotification($token, $title, $message, $data = [])
    {
        // Integrate with FCM or similar push notification service
        // For now, just log it
        \Log::info("Push notification to {$token}: {$title} - {$message}");
    }
}

