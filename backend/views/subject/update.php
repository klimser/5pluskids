<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $subject common\models\Subject */

$this->title = $subject->isNewRecord ? 'Новый курс' : $subject->name;
$this->params['breadcrumbs'][] = ['label' => 'Курсы по направлениям', 'url' => ['index']];
$this->params['breadcrumbs'][] = $subject->name;

?>
<div class="subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="subject-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($subject, 'name')->textInput(['required' => true, 'maxlength' => true]) ?>

        <?=
        $form->field($subject, 'iconFile', ['options' => ['class' => 'form-group col-xs-10']])
            ->fileInput(['required' => $subject->isNewRecord, 'accept' => 'image/jpeg,image/png', 'data' => ['id' => $subject->id]]);
        ?>

        <div class="col-xs-2">
            <?php if ($subject->icon): ?>
                <img src="<?= $subject->iconUrl; ?>" style="max-width: 100%;">
            <?php endif; ?>
        </div>

        <?=
        $form->field($subject, 'imageFile', ['options' => ['class' => 'form-group col-xs-10']])
            ->fileInput(['accept' => 'image/jpeg,image/png', 'data' => ['id' => $subject->id]]);
        ?>
        <div class="col-xs-2">
            <?php if ($subject->image): ?>
                <img src="<?= $subject->imageUrl; ?>" style="max-width: 100%;">
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>

        <?= $form->field($subject, 'description')->textarea() ?>

        <?=
        $form->field($subject, 'content')->widget(\dosamigos\tinymce\TinyMce::class, \backend\components\DefaultValuesComponent::getTinyMceSettings());
        ?>

        <?= $this->render('/webpage/_form', [
            'form' => $form,
            'webpage' => $subject->webpage,
            'module' => isset($module) ? $module : null,
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton($subject->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $subject->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
