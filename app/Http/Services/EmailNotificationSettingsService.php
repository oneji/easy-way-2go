<?php

namespace App\Http\Services;

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

        $notificationSetting = new EmailNotificationSettings();
        $notificationSetting->type = $request->type;
        $notificationSetting->user_id = $user->id;
        $notificationSetting->user_role = $user->role;
        $notificationSetting->save(); 
    }
}