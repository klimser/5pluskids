<?php
/* @var $subjects \common\models\Subject[] */
?>

<div class="row subject-carousel-widget carousel-widget">
    <div class="col-xs-12 col-sm-8 col-sm-push-4 col-md-9 col-md-push-3 carousel-block">
        <div id="carousel-nav-1" class="carousel-nav"></div>
        <div id="owl-carousel-1" class="owl-carousel owl-theme">
            <?php foreach ($subjects as $subject): ?>
                <div class="carousel-item">
                    <a href="<?= Yii::$app->homeUrl . $subject->webpage->url; ?>">
                        <img src="<?= $subject->iconUrl; ?>"><br>
                        <span class="link-body"><?= $subject->name; ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9 info-block">
        <div class="widget-light">Курсы</div>
        <div class="widget-dark">для детей</div>
        <a href="#" class="widget-button" onclick="MainPage.launchModal('subject'); return false;">Записаться на курс</a>
    </div>
    <div class="clearfix"></div>
</div>