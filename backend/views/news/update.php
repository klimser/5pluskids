<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $news common\models\News */

$this->title = $news->isNewRecord ? 'Новая новость' : $news->name;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $news->name;

?>
<div class="subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="subject-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($news, 'name')->textInput(['required' => true, 'maxlength' => true]) ?>

        <?=
        $form->field($news, 'imageFile', ['options' => ['class' => 'form-group col-xs-10']])
            ->fileInput(['required' => $news->isNewRecord, 'accept' => 'image/jpeg,image/png', 'data' => ['id' => $news->id]]);
        ?>

        <div class="col-xs-2">
            <?php if ($news->image): ?>
                <img src="<?= $news->imageUrl; ?>" style="max-width: 100%;">
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>

        <?=
        $form->field($news, 'content')->widget(\dosamigos\tinymce\TinyMce::class, \backend\components\DefaultValuesComponent::getTinyMceSettings());
        ?>

        <?= $this->render('/webpage/_form', [
            'form' => $form,
            'webpage' => $news->webpage,
            'module' => isset($module) ? $module : null,
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton($news->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $news->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
