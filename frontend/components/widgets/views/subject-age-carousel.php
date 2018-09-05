<?php
/* @var $subjects \common\models\SubjectAge[] */
?>

<div class="row subject-carousel-widget carousel-widget">
    <div class="col-xs-12 col-sm-8 col-md-9 carousel-block">
        <div id="carousel-nav-2" class="carousel-nav"></div>
        <div id="owl-carousel-2" class="owl-carousel owl-theme">
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
    <div class="col-xs-12 col-sm-4 col-md-3 info-block">
        <div class="widget-light">Курсы</div>
        <div class="widget-dark">по возрасту</div>
        <a href="#" class="widget-button" onclick="MainPage.launchModal('subjectAge'); return false;">Записаться на курс</a>
    </div>
    <div class="clearfix"></div>
</div>