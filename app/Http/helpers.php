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
