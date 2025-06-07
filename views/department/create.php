<?php

/**
 * @var $model \app\models\Department
 */

use app\models\Task;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $model->isNewRecord ? 'Создание отдела' : 'Редактирование раздела';

?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name', ['labelOptions' => ['style' => 'font-weight: bold;']]) ?>

<?= $form->field($model, 'code', ['labelOptions' => ['style' => 'font-weight: bold;']]) ?>

<?= $form->field($model, 'contact', ['labelOptions' => ['style' => 'font-weight: bold;']]) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
