<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use app\service\LdapService;
use app\service\UserService;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'grant-access'],
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->getRequest()->getQueryParams()),
        ]);
    }

    public function actionGrantAccess($username)
    {
        $user = User::findOne(['username' => $username]);
        if (!$user) {
            $ldapService = new LdapService();
            $userService = new UserService();
            $user = $userService->getOrCreateUser($username, $ldapService->findLdapUser($username));
        }
        $user->setRole(User::ROLE_ADMIN);
        return $this->redirect('index');
    }
}