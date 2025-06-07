<?php

namespace app\controllers;

use app\models\Task;
use app\models\TaskSearch;
use app\models\User;
use app\service\LdapService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TaskController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'delete'],
                        'roles' => [User::ROLE_ADMIN, User::ROLE_MANAGER],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'execute', 'prolonge'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TaskSearch();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->getRequest()->getQueryParams()),
        ]);
    }

    public function actionCreate()
    {
        $model = new Task();
        $model->status = Task::STATUS_ACTIVE;
        $model->creator_id = Yii::$app->user->identity->id;
        $ldapService = new LdapService();

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
            'ldapUserList' => $ldapService->getLdapUserList(),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ldapService = new LdapService();

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'ldapUserList' => $ldapService->getLdapUserList(),
        ]);
    }

    public function actionExecute($id)
    {
        $model = $this->findModel($id);
        $model->status = Task::STATUS_READY;
        $model->save();
        return $this->redirect('index');
    }

    public function actionProlonge($id)
    {
        $model = $this->findModel($id);
        $model->status = Task::STATUS_REQUEST_FOR_PROLONGE;
        $model->save();
        return $this->redirect('index');
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect('index');
    }

    private function findModel($id)
    {
        $model = Task::findOne($id);

        if (\Yii::$app->user->identity->getRole() === User::ROLE_ADMIN ||
            $model->ldap_uid === \Yii::$app->user->identity->username ||
            (\Yii::$app->user->identity->getRole() === User::ROLE_MANAGER &&
                $model->creator_id === \Yii::$app->user->identity->id)
        ) {
            return $model;
        }

        throw new NotFoundHttpException('Поручение не найдено!');
    }
}