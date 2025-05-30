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
            'template' => '{grant-access}',
            'buttons' => [
                'grant-access' => function ($url, $model) {
                    if (User::findOne(['username' => $model['uid']])?->getRole() !== User::ROLE_ADMIN) {
                        return Html::a(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14v8H4a8 8 0 0 1 8-8Zm0-1c-3.315 0-6-2.685-6-6s2.685-6 6-6s6 2.685 6 6s-2.685 6-6 6Zm9 4h1v5h-8v-5h1v-1a3 3 0 1 1 6 0v1Zm-2 0v-1a1 1 0 1 0-2 0v1h2Z"/></svg>',
                            Url::to(['grant-access', 'username' => $model['uid']]),
                        );
                    }
                }
            ]
        ],
    ],
]) ?>
