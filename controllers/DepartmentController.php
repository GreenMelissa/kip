<?php

namespace app\controllers;

use app\models\Department;
use app\models\DepartmentSearch;
use app\models\Task;
use app\models\TaskSearch;
use app\models\User;
use app\service\LdapService;
use yii\filters\AccessControl;
use yii\web\Controller;

class DepartmentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'delete', 'index', 'update'],
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new DepartmentSearch();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->getRequest()->getQueryParams()),
        ]);
    }

    public function actionCreate()
    {
        $model = new Department();

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->validate() && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Department::findOne($id);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->validate() && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Department::findOne($id);
        $model->delete();
        return $this->redirect('index');
    }

}