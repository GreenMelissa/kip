<?php

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel TaskSearch
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Url;
use app\models\TaskSearch;

$this->title = 'Поручения';

$this->registerCss('.table > :not(caption) > * > * {
    background-color: unset;
}');

?>

<h1><?= $this->title ?></h1>

<?php if (\Yii::$app->user->identity->getRole() === User::ROLE_ADMIN): ?>
    <a class="btn btn-primary my-3" href="<?= Url::to(['task/create']) ?>">
        Создать поручение
    </a>
<?php endif ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ($model, $index, $widget, $grid){
        $now = time();
        $your_date = strtotime($model->active_until);
        $datediff = $your_date - $now;

        if (round($datediff / (60 * 60 * 24)) < 3) {
            return ['style' => 'background-color: #f77c7c;'];
        }

        if (round($datediff / (60 * 60 * 24)) < 7) {
            return ['style' => 'background-color: #fbf276;'];
        }

        return ['style' => 'background-color: #87fb67;'];
    },
    'columns' => [
        'id',
        'ldap_uid',
        'name',
        'active_until',
        [
            'class' => ActionColumn::class,
            'template' =>
                \Yii::$app->user->identity->getRole() === User::ROLE_ADMIN ?
                '{update} {delete}' :
                '{update}',
        ],
    ],
]) ?>
