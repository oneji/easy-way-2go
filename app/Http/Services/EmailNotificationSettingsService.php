<?php

namespace App\Http\Services;

use App\Brigadir;
use App\Client;
use App\Driver;
use App\EmailNotificationSettings;
use Illuminate\Http\Request;

class EmailNotificationSettingsService
{
    /**
     * Get all email notification settings
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function all(Request $request)
    {
        $user = $request->authUser;
        
        $notifications = EmailNotificationSettings::whereUserId($user->id)
            ->whereUserRole($user->role)
            ->get();

        return $notifications;
    }

    /**
     * Update email notification settings
     * 
     * @param \Illuminate\Http\Request $request 
     */
    public function update(Request $request)
    {
        $user = $request->authUser;
        $this->updateEmailNotificationsPermission($user, $request->allow_email_notifications); 

        foreach ($request->types as $type) {
            EmailNotificationSettings::updateOrCreate([
                'type' => $type,
                'user_id' => $user->id,
                'user_role' => $user->role
            ]);
        }        
    }

    /**
     * Update "allow_email_notifications" flag in user
     * 
     * @param object user
     * @param int $allow
     */
    public function updateEmailNotificationsPermission($user, $allow)
    {
        if($user->role === 'brigadir') {
            Brigadir::whereId($user->id)->update([
                'allow_email_notifications' => $allow
            ]);
        } else if($user->role === 'driver') {
            Driver::whereId($user->id)->update([
                'allow_email_notifications' => $allow
            ]);
        } else if($user->role === 'client') {
            Client::whereId($user->id)->update([
                'allow_email_notifications' => $allow
            ]);
        }
    }
}