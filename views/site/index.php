<?php

/** @var yii\web\View $this */
/** @var $model \app\models\LoginForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'КИП';
?>

<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h2 class="display-4">Вход в систему</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
