<?php
    function formatPostContent($content) {
        $content = str_replace(array("\n","\r"), ' ', $content); //Remove new lines
        $content = preg_replace('/\s+/', ' ', $content); //Remove duplicate spaces
        $content = trim($content); //Trim
        $content = strip_tags($content); //Remove tags

        if (strlen($content) >= 93) //Set maximum length
            $content = substr($content, 0, 91) . '...'; // Add ellipsis to end of string to
                                                                     // suggest there is more to the post

        return $content;
    }

    function formatUsernameLink($userID) {
        $user = \App\User::find($userID);

        if ($user == null)
            return '<a href="#">Unknown User</a>';

        return '<a href="/user/' . $userID . '">' . $user->name . '</a>';
    }

    function getSettingValue($id) {
        $setting = \App\Setting::where('name', $id)->get();
        if (count($setting) > 0) {
            return $setting[0]->value;
        } else return "";
    }

    function userHasPermission($action) {
        $settingVal = intval(getSettingValue($action));
        return auth()->user()->group->power_level >= $settingVal; //Return true if user's power level >= setting's level
    }

    function getBanLengths() {
        return [
            '300' => '5 Minutes',
            '1800' => '30 Minutes',
            '3600' => '1 Hour',
            '7200' => '2 Hours',
            '43200' => '12 Hours',
            '86400' => '1 Day',
            '172800' => '2 Days',
            '604800' => '1 Week',
            '1209600' => '2 Weeks',
            '2419200' => '4 Weeks',
            '0' => 'Permanent'
        ];
    }

    function isUserBanned(\App\User $user) {
        if ($user->group->is_banned_group) { //if user is in a banned group
            $ban = \App\Ban::where('user_id', $user->id)->get()[0];
            if ($ban->length == 0 || strtotime($ban->created_at) + $ban->length > time()) { //if still banned
                return true;
            } else { //ban expired, reset user group and remove ban
                $user->group_id = $ban->group_id;
                $user->save();
                $ban->delete();
            }
        }
        return false;
    }
