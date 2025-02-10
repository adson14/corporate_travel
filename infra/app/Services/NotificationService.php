<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\OrderApprovedNotification;
use Application\Contract\INotificationService;

class NotificationService implements INotificationService
{

    public function save(string $id, string $message, string $email): void
    {
        // Localiza o usuário associado ao pedido
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->notify(new OrderApprovedNotification($id,$message));
        }
    }


}
