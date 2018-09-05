<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $user backend\models\User */
/* @var $isAdmin bool */

/** @var \yii\web\User $currentUser */
$currentUser = Yii::$app->user;

$this->title = 'Профиль';
if ($isAdmin) $this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Профиль' . ($isAdmin ? ' ' . $user->name : '');
?>
<div class="user-update">
    <div class="user-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'name')->textInput(['maxlength' => true]); ?>

        <?= $form->field($user, 'username')->textInput(['maxlength' => true, 'required' => true]); ?>

        <?= $form->field($user, 'password')->passwordInput(['data' => ['id' => $user->id]]); ?>

        <?php if ($isAdmin): ?>
            <?= $form->field($user, 'role')->dropDownList(\backend\models\User::$roleLabels); ?>
        <?php endif;?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>