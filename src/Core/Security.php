<?php


namespace App\Core;


class Security
{
    public static function isAuthenticatedUser(): bool
    {
        if (App::get("user") !== null)
            return true;

        return false;

    }
}