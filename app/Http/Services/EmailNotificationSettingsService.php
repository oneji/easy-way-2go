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
        
        $settings = EmailNotificationSettings::select('id', 'data')
            ->whereUserId($user->id)
            ->whereUserRole($user->role)
            ->first();

        return $settings ? $settings->data : null;
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

        if($user->role === 'brigadir') {
            $data = [
                'my_orders' => $request->my_orders,
                'my_messages' => $request->my_messages,
                'drivers_orders' => isset($request->drivers_orders) ? $request->drivers_orders : false,
                'drivers_messages' => isset($request->drivers_messages) ? $request->drivers_messages : false
            ];
        } else {
            $data = [
                'my_orders' => $request->my_orders,
                'my_messages' => $request->my_messages
            ];
        }

        $settings = EmailNotificationSettings::whereUserId($user->id)->whereUserRole($user->role)->first();

        if($settings) {
            $settings->update([ 'data' => $data ]);
        } else {
            $newSettings = new EmailNotificationSettings([
                'data' => $data,
                'user_id' => $user->id,
                'user_role' => $user->role
            ]);
            $newSettings->save();
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