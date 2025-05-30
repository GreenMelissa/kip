<?php

/**
 * @var $model Task
 * @var $ldapUserList array
 */

use app\models\Task;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Создание поручения';

?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name', ['labelOptions' => ['style' => 'font-weight: bold;']]) ?>

<?= $form->field($model, 'ldap_uid', ['labelOptions' => ['style' => 'font-weight: bold;']])->dropDownList($ldapUserList) ?>

<?= $form->field($model, 'description', ['labelOptions' => ['style' => 'font-weight: bold;']])->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'comment', ['labelOptions' => ['style' => 'font-weight: bold;']])->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'active_until', ['labelOptions' => ['style' => 'font-weight: bold;']])->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
]) ?>

<div class="form-group">
    <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
