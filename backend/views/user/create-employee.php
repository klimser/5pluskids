<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $user backend\models\User */

$this->title = 'Добавить сотрудника';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Новый сотрудник';
?>
<div class="user-create">
    <h1><?= Html::encode($this->title); ?></h1>

    <div class="user-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'name')->textInput(['maxlength' => true]); ?>

        <?= $form->field($user, 'username')->textInput(['maxlength' => true, 'required' => true]); ?>

        <?= $form->field($user, 'password')->passwordInput(['required' => $user->isNewRecord, 'data' => ['id' => $user->id]]); ?>

        <?= $form->field($user, 'role')->dropDownList(User::$roleLabels); ?>

        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary pull-right']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>