<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $webpage \common\models\Webpage|null */
/* @var $teachers \common\models\Teacher[] */
/* @var $prefix string */

$this->title = 'Настройки страницы "Учителя"';
$this->params['breadcrumbs'][] = ['label' => 'Учителя', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Настройки страницы';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['options' => ['onSubmit' => 'return Main.submitSortableForm(this);']]); ?>

    <div class="row">
        <div class="col-xs-12">
            <?php
                $sortableItems = [];
                foreach ($teachers as $teacher) {
                    $sortableItems[] = [
                        'content' => '<span class="glyphicon glyphicon-sort"></span> '. $teacher->name,
                        'options' => ['id' => $prefix . $teacher->id],
                    ];
                }
            ?>
            <?= \yii\jui\Sortable::widget([
                 'items' => $sortableItems,
                 'options' => ['tag' => 'ol'],
                 'itemOptions' => ['tag' => 'li'],
                 'clientOptions' => ['cursor' => 'move'],
             ]); ?>


<?php /*
            <div class="well">
                <ol class="menu_items">
                    <?php foreach ($subjects as $subject): ?>
                        <li id="menuItem_<?= $subject->id; ?>">
                            <div>
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <?= $subject->name; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
 */ ?>
        </div>
    </div>
    <hr>

    <?= $this->render('/webpage/_form', [
        'form' => $form,
        'webpage' => $webpage,
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
