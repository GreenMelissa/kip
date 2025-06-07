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
                        'actions' => ['index', 'update'],
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
            'dataProvider' => $searchModel->search(\Yii::$app->getRequest()->getQueryParams()),
        ]);
    }

    public function actionUpdate($username)
    {
        $model = User::findOne(['username' => $username]);
        if (!$model) {
            $ldapService = new LdapService();
            $userService = new UserService();
            $model = $userService->getOrCreateUser($username, $ldapService->findLdapUser($username));
        }
        $model->role = $model->getRole();

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->validate() && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}