<?php

namespace app\models;

use app\service\LdapService;
use yii\data\ArrayDataProvider;

class UserSearch
{
    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'name' => 'Имя',
            'email' => 'Email',
            'isAdmin' => 'Админ',
        ];
    }

    public function search($params)
    {
        $allModels = [];

        $ldapService = new LdapService();
        $data = $ldapService->findLdapUser('*');
        foreach ($data as $item) {
            if ($item['uid'] ?? null) {
                $allModels[] = [
                    'uid' => $item['uid'][0],
                    'name' => $item['displayname'][0],
                    'email' => $item['mail'][0],
                    'isAdmin' => User::findOne(['username' => $item['uid'][0]])?->getRole() === User::ROLE_ADMIN,
                ];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $allModels,
        ]);

        return $dataProvider;
    }
}