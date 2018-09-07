<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $teacher common\models\Teacher */

$this->title = $teacher->isNewRecord ? 'Новый учитель' : $teacher->name;
$this->params['breadcrumbs'][] = ['label' => 'Учителя', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="teacher-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="teacher-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($teacher, 'name')->textInput(['required' => true, 'maxlength' => true]) ?>

        <?= $form->field($teacher, 'title')->textInput(['required' => true, 'maxlength' => true]) ?>

        <?=
        $form->field($teacher, 'photoFile', ['options' => ['class' => 'form-group col-xs-10']])
            ->fileInput(['accept' => 'image/jpeg,image/png', 'data' => ['id' => $teacher->id]]);
        ?>
        <div class="col-xs-2">
            <?php if ($teacher->photo): ?>
                <img src="<?= $teacher->imageUrl; ?>" style="max-width: 100%;">
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>

        <?= $form->field($teacher, 'description')->textarea() ?>

        <?= $this->render('/webpage/_form', [
            'form' => $form,
            'webpage' => $teacher->webpage,
            'module' => isset($module) ? $module : null,
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton($teacher->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $teacher->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
