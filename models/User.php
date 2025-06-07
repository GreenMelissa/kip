<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * @property $id int
 * @property $username string
 * @property $display_name string
 * @property $email string
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';

    public const ROLE_USER = 'user';

    public $role;

    public function rules()
    {
        return [
            ['email', 'email'],
            [['display_name'], 'string'],
            ['department_id', 'exist', 'targetClass' => Department::class, 'targetAttribute' => 'id'],
            ['role', 'in', 'range' => [User::ROLE_MANAGER, User::ROLE_USER, User::ROLE_ADMIN]],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'display_name' => 'Имя',
            'email' => 'Email',
            'department_id' => 'Отдел',
            'role' => 'Роль',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->role) {
            $this->setRole($this->role);
        }

        return parent::beforeSave($insert);
    }

    public function getRole()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        $default_roles = Yii::$app->authManager->defaultRoles;

        foreach ($roles as $key => $value) {
            if (in_array($key, $default_roles)) {
                unset($roles[$key]);
            }
        }

        if (!empty($roles)) {
            return array_keys($roles)[0];
        }

        return User::ROLE_USER;
    }

    public static function getRoleList(): array
    {
        return [
            User::ROLE_USER => 'Пользователь',
            User::ROLE_MANAGER => 'Руководитель',
            User::ROLE_ADMIN => 'Администратор',
        ];
    }

    public function setRole($roleName)
    {
        if ($this->id !== null && !empty($roleName)) {
            $manager = Yii::$app->authManager;
            $manager->revokeAll($this->id);
            $manager->assign($manager->getRole($roleName), $this->id);
        }
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }


    public static function tableName()
    {
        return 'user';
    }
}
