<?php

/**
 * @var $model Task
 * @var $ldapUserList array
 */

use app\models\Task;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'ldap_uid')->dropDownList($ldapUserList) ?>

<?= $form->field($model, 'status')->dropDownList([
        Task::STATUS_ACTIVE => 'Активное',
        Task::STATUS_EXPIRED => 'Просроченное',
]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'active_until')->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
]) ?>

<div class="form-group">
    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
