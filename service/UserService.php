<?php

namespace app\service;

use app\models\User;

class UserService
{
    /**
     * Поиск пользователя или создание нового
     */
    public function getOrCreateUser($username, $ldapUser)
    {
        $user = User::findByUsername($username);

        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->display_name = $ldapUser[0]['displayname'][0] ?? null;
            $user->post = $ldapUser[0]['post'][0] ?? null;
            $user->email = $ldapUser[0]['mail'][0] ?? null;
            $user->save();
        }

        return $user;
    }
}