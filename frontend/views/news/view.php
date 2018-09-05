<?php

/* @var $this \yii\web\View */
/* @var $news common\models\News */
/* @var $webpage common\models\Webpage */
/* @var $newsWebpage common\models\Webpage */

$this->params['breadcrumbs'][] = ['url' => Yii::$app->homeUrl . $newsWebpage->url, 'label' => 'Новости'];
$this->params['breadcrumbs'][] = $news->name;
?>

<div class="row">
    <div class="col-xs-12 text-content">
        <?= $news->content; ?>
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