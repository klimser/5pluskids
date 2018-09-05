<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $subjectAge common\models\SubjectAge */

$this->title = $subjectAge->isNewRecord ? 'Новый курс' : $subjectAge->name;
$this->params['breadcrumbs'][] = ['label' => 'Курсы по возрасту', 'url' => ['index']];
$this->params['breadcrumbs'][] = $subjectAge->name;

?>
<div class="subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="subject-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($subjectAge, 'name')->textInput(['required' => true, 'maxlength' => true]) ?>

        <?=
        $form->field($subjectAge, 'iconFile', ['options' => ['class' => 'form-group col-xs-10']])
            ->fileInput(['required' => $subjectAge->isNewRecord, 'accept' => 'image/jpeg,image/png', 'data' => ['id' => $subjectAge->id]]);
        ?>

        <div class="col-xs-2">
            <?php if ($subjectAge->icon): ?>
                <img src="<?= $subjectAge->iconUrl; ?>" style="max-width: 100%;">
            <?php endif; ?>
        </div>

        <?=
        $form->field($subjectAge, 'imageFile', ['options' => ['class' => 'form-group col-xs-10']])
            ->fileInput(['accept' => 'image/jpeg,image/png', 'data' => ['id' => $subjectAge->id]]);
        ?>
        <div class="col-xs-2">
            <?php if ($subjectAge->image): ?>
                <img src="<?= $subjectAge->imageUrl; ?>" style="max-width: 100%;">
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>

        <?= $form->field($subjectAge, 'description')->textarea() ?>

        <?=
        $form->field($subjectAge, 'content')->widget(\dosamigos\tinymce\TinyMce::class, \backend\components\DefaultValuesComponent::getTinyMceSettings());
        ?>

        <?= $this->render('/webpage/_form', [
            'form' => $form,
            'webpage' => $subjectAge->webpage,
            'module' => isset($module) ? $module : null,
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton($subjectAge->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $subjectAge->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
