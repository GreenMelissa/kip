<?php

namespace app\models;

use app\service\LdapService;
use app\service\UserService;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public const SESSION_DURATION = 3600 * 24 * 30;

    public $username;
    public $password;


    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function login()
    {
        $ldapService = new LdapService();
        $userService = new UserService();

        if ($this->validate()) {
            $ldapUser = $ldapService->findLdapUser($this->username);
            if ($this->password === $ldapUser[0]['userpassword'][0] ?? null) {
                return Yii::$app->user->login(
                    $userService->getOrCreateUser($this->username, $ldapUser),
                    self::SESSION_DURATION
                );
            } else {
                $this->addError('password', 'Указан неверный пароль');
            }
        }
        return false;
    }
}
