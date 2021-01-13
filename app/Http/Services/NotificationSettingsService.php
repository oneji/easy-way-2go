<?php

namespace App\Http\Services;

use App\NotificationSettings;
use Illuminate\Http\Request;

class NotificationSettingsService
{
    /**
     * Get all notification settings
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function all(Request $request)
    {
        $user = $request->authUser;
        
        $notifications = NotificationSettings::whereUserId($user->id)
            ->whereUserRole($user->role)
            ->get();

        return $notifications;
    }

    /**
     * Update notification settings
     * 
     * @param \Illuminate\Http\Request $request 
     */
    public function update(Request $request)
    {
        $user = $request->authUser;

        $notificationSetting = new NotificationSettings();
        $notificationSetting->type = $request->type;
        $notificationSetting->user_id = $user->id;
        $notificationSetting->user_role = $user->role;
        $notificationSetting->save(); 
    }
}