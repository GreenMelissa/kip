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

$this->title = 'Отделы';

?>

<h1><?= $this->title ?></h1>

<a class="btn btn-primary my-3" href="<?= Url::to(['department/create']) ?>">
    Создать отдел
</a>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
        'code',
        'contact',
        [
            'class' => ActionColumn::class,
            'template' => '{update} {delete}',
        ],
    ],
]) ?>
