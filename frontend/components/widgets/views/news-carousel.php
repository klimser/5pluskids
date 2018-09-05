<?php
/* @var $news \common\models\News[] */
/* @var $newsWebpage \common\models\Webpage */
?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="text-center text-uppercase">Новости</h2>
    </div>
</div>
<div class="row news-carousel-widget carousel-widget">
    <div class="col-xs-12">
        <div id="owl-carousel-4" class="owl-carousel owl-theme">
            <?php foreach ($news as $newsItem): ?>
                <?= $this->render('/news/_block', ['news' => $newsItem, 'grid' => false]); ?>
            <?php endforeach; ?>
        </div>
        <div id="carousel-nav-4" class="carousel-nav compact-carousel-nav">
            <a href="<?= Yii::$app->homeUrl . $newsWebpage->url; ?>" class="all-items-link">
                <span class="icon icon-news"></span>
                <span class="link-body">Все новости</span>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>