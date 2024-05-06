<?php

if (!function_exists('getUserAvatar')) {
    function getUserAvatar($user)
    {
        if (!empty($user->avatar)) {
            return asset('storage/' . $user->avatar);
        } else {
            return 'https://ui-avatars.com/api/?size=128&background=6366f1&color=fff&name=' . urlencode($user->first_name . ' ' . $user->last_name);
        }
    }
}