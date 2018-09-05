<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Webpage;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\MenuItem */
/* @var $form yii\widgets\ActiveForm */

if (!isset($config)) $config = [];
?>

<div class="menu-item-form">
    <?php $form = ActiveForm::begin($config); ?>

    <?= Html::activeHiddenInput($model, 'id'); ?>
    <?= Html::activeHiddenInput($model, 'menu_id'); ?>

    <?= $form->field($model, 'webpage_id')->listBox(ArrayHelper::map(Webpage::find()->orderBy(['module_id' => SORT_ASC, 'title' =>SORT_ASC])->all(), 'id', 'title'), ['onclick' => 'MenuItem.setType(this, "webpage_id");', 'onfocus' => 'MenuItem.setType(this, "webpage_id");']) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'onclick' => 'MenuItem.setType(this, "url");', 'onfocus' => 'MenuItem.setType(this, "url");']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'attr')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
