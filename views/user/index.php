<?php

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel TaskSearch
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\TaskSearch;

$this->title = 'Пользователи';

?>

<h1><?= $this->title ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Логин',
            'attribute' => 'uid',
        ],
        [
            'label' => 'Имя',
            'attribute' => 'name',
        ],
        [
            'label' => 'Email',
            'attribute' => 'email',
        ],
        [
            'label' => 'Отдел',
            'attribute' => 'department',
        ],
        [
            'label' => 'Роль',
            'attribute' => 'role',
            'value' => function ($user) {
               return $user['role'] ? User::getRoleList()[$user['role']] : 'Не авторизован в системе';
            },
        ],
        [
            'label' => 'Админ',
            'attribute' => 'isAdmin',
            'format' => 'raw',
            'value' => function ($user) {
                if ($user['isAdmin']) {
                    return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48"><circle cx="24" cy="24" r="21" fill="#4CAF50"/><path fill="#CCFF90" d="M34.6 14.6L21 28.2l-5.6-5.6l-2.8 2.8l8.4 8.4l16.4-16.4z"/></svg>';
                } else {
                    return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><path fill="#F92F60" d="M24.879 2.879A3 3 0 1 1 29.12 7.12l-8.79 8.79a.125.125 0 0 0 0 .177l8.79 8.79a3 3 0 1 1-4.242 4.243l-8.79-8.79a.125.125 0 0 0-.177 0l-8.79 8.79a3 3 0 1 1-4.243-4.242l8.79-8.79a.125.125 0 0 0 0-.177l-8.79-8.79A3 3 0 0 1 7.12 2.878l8.79 8.79a.125.125 0 0 0 .177 0l8.79-8.79Z"/></svg>';
                }
            },
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a(
                        '<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>',
                        Url::to(['update', 'username' => $model['uid']]),
                    );
                },
            ]
        ],
    ],
]) ?>
