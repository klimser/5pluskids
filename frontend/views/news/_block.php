<?php

/* @var $this \yii\web\View */
/* @var $news \common\models\News */
/* @var $grid bool */

?>
<div class="news-item <?php if ($grid): ?>col-xs-12 col-sm-6 col-md-3<?php endif; ?>">
    <a href="<?= Yii::$app->homeUrl . $news->webpage->url; ?>">
        <img src="<?= $news->imageUrl; ?>" class="max-width-100">
        <div class="link-body"><?= $news->name; ?></div>
        <div class="news-date">
            <span class="icon icon-calendar"></span>
            <?= $news->createDate->format('d.m.Y'); ?>
        </div>
    </a>
</div>