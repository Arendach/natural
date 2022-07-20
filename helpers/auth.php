<?php

use App\Models\User;

function user(int $id = null): User|null
{
    if (!$id){
        return Auth::user();
    }

    return null;
}

/**
 * @return bool|mixed
 */
function is_auth()
{
    if (isset($_SESSION['is_auth'])) {
        return $_SESSION['is_auth'];
    }

    return false;
}

/**
 * @param $date
 * @return bool
 */
function is_online($date): bool
{
    return time() - $date < 300;
}

/**
 * @param int|string $key
 * @return bool
 */
function can($key = -1): bool
{
    if ($key == -1)
        if (user()->access == -1)
            return true;
        else
            return false;
    elseif (is_string($key))
        return is_array(user()->access) ? (boolean)in_array($key, user()->access) : true;
    else
        return false;
}

/**
 * @param string|int $key
 * @return bool
 */
function cannot($key): bool
{
    return !can($key);
}