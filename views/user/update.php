<?php

/**
 * @var $model \app\models\User
 */

use app\models\Department;
use app\models\Task;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\User;

$this->title = 'Редактирование пользователя';

?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'display_name', ['labelOptions' => ['style' => 'font-weight: bold;']]) ?>

<?= $form->field($model, 'email', ['labelOptions' => ['style' => 'font-weight: bold;']]) ?>

<?= $form
    ->field($model, 'department_id', ['labelOptions' => ['style' => 'font-weight: bold;']])
    ->dropDownList(Department::getDepartmentList())
?>

<?= $form
    ->field($model, 'role', ['labelOptions' => ['style' => 'font-weight: bold;']])
    ->dropDownList(User::getRoleList())
?>

<div class="form-group">
    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
