<?php

/* @var $this \yii\web\View */
/* @var $promotion common\models\Promotion
/* @var $webpage common\models\Webpage */
/* @var $promotionsWebpage common\models\Webpage */

$this->params['breadcrumbs'][] = ['url' => Yii::$app->homeUrl . $promotionsWebpage->url, 'label' => 'Акции'];
$this->params['breadcrumbs'][] = $promotion->name;
?>

<div class="row">
    <div class="col-xs-12 text-content">
        <?= $promotion->content; ?>
    </div>
</div>
<?php
/*
?><div class="row">
    <div class="col-xs-12">
        <div class="title-separator">Другие новости</div>
        <div class="row">
            <?= \frontend\components\widgets\RandomNewsWidget::widget(['exceptSubject' => $news->id]); ?>
        </div>
    </div>
</div>
*/ ?>