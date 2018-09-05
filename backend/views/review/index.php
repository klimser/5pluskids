<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\models\OrderSearch */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">
    <div class="pull-right"><a href="<?= \yii\helpers\Url::to(['page']); ?>">Настройки страницы отзывов</a></div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $index, $widget, $grid) {
            $class = 'review-' . $model->id;
            if ($model->status == 'new') {
                $class .= ' warning';
            }

            return ['class' => $class];
        },
        'columns' => [
            [
                'attribute' => 'name',
            ],
            [
                'attribute' => 'message',
                'filter' => false,
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'createDateString',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'weekStart' => 1,
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'content' => function ($model, $key, $index, $column) {
                    return \common\models\Review::$statusLabels[$model->status];
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    array_merge(['' => 'Любой'], \common\models\Review::$statusLabels),
                    ['class' => 'form-control']
                ),
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '<nobr>{approve}{update}{delete}</nobr>',
                'buttonOptions' => ['class' => 'btn btn-default margin-right-10'],
                'buttons' => [
                    'approve' => function ($url, $model, $key) {
                        if ($model->status == \common\models\Review::STATUS_APPROVED) return false;
                        /** @var \common\models\Subject $model */
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok']), '#', ['class' => 'btn btn-default margin-right-10 approve', 'title' => 'Утвердить', 'onclick' => 'return Main.changeEntityStatus("review", ' . $model->id . ', "' . \common\models\Review::STATUS_APPROVED . '");']);
                    }
                ],
            ],
        ],
    ]); ?>

</div>
