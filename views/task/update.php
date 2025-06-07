<?php

/**
 * @var $model Task
 * @var $ldapUserList array
 */

use app\models\Task;
use app\models\User;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$canUpdate = \Yii::$app->user->identity->getRole() === User::ROLE_ADMIN || \Yii::$app->user->identity->getRole() === User::ROLE_MANAGER;

?>

<?php $form = ActiveForm::begin(); ?>



<?php if ($canUpdate): ?>
    <?= $form->field($model, 'name', ['labelOptions' => ['style' => 'font-weight: bold;']]) ?>

    <?= $form->field($model, 'ldap_uid', ['labelOptions' => ['style' => 'font-weight: bold;']])->dropDownList($ldapUserList) ?>

    <?= $form->field($model, 'status', ['labelOptions' => ['style' => 'font-weight: bold;']])->dropDownList([
            Task::STATUS_ACTIVE => 'Активное',
            Task::STATUS_EXPIRED => 'Просроченное',
    ]) ?>

    <?= $form->field($model, 'active_until', ['labelOptions' => ['style' => 'font-weight: bold;']])->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>
<?php endif ?>

<?php if ($canUpdate): ?>
    <?= $form->field($model, 'description', ['labelOptions' => ['style' => 'font-weight: bold;']])->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'comment', ['labelOptions' => ['style' => 'font-weight: bold;']])->textarea(['rows' => 6]) ?>
<?php else : ?>
    <h5 style="font-weight: bold;">Заголовок</h5>
    <p><?= $model->name ?></p>
    <h5 style="font-weight: bold;">Описание поручения</h5>
    <p><?= $model->description ?></p>
    <h5 style="font-weight: bold;">Комментарий к поручению</h5>
    <p><?= $model->comment ?></p>
    <h5 style="font-weight: bold;">Срок</h5>
    <p style="font-weight: bold;"><?= $model->active_until ?></p>
    <hr>
    <h5 style="font-weight: bold;">Статус</h5>
    <p style="font-weight: bold;"><?= Task::getStatusList()[$model->status] ?></p>
    <hr>
<?php endif ?>

<?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>

<?php if ($model->attachments): ?>
    <?php foreach ($model->attachments as $key => $attachment): ?>
        <a href="/uploads/<?= $attachment->filename ?>" style="font-weight: bold;">
            Вложение <?= $key + 1 ?>, загрузил <?= User::findOne($attachment->user_id)->username ?>
        </a>
        <hr>
    <?php endforeach ?>
<?php endif ?>

<?php if ($model->history): ?>
    <?php foreach ($model->history as $key => $taskHistory): ?>
        Статус "<?= Task::getStatusList()[$taskHistory->status] ?>" изменен <?= date('Y-m-d H:i:s', $taskHistory->created_at) ?>
        пользователем <?= User::findOne($taskHistory->user_id)->username ?>
        <hr>
    <?php endforeach ?>
<?php endif ?>

<?php if ($model->status != Task::STATUS_READY) : ?>
    <div class="form-group">
        <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Исполнить', Url::to(['execute', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
        <?php if ($model->status != Task::STATUS_REQUEST_FOR_PROLONGE) : ?>
            <?= Html::a('Запросить продление срока', Url::to(['execute', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
        <?php endif ?>
    </div>
<?php endif ?>

<?php ActiveForm::end(); ?>
