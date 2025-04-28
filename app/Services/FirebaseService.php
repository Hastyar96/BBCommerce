<?php

namespace App\Services;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;

class FirebaseService
{
    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendNotification($token, $title, $body)
    {
        try {
            $message = CloudMessage::withTarget($token)
                ->withNotification(Notification::create($title, $body));

            $this->messaging->send($message);
        } catch (InvalidMessage $e) {
            // Handle errors
            return ['error' => $e->getMessage()];
        }
        return ['status' => 'Notification sent successfully'];
    }
}
