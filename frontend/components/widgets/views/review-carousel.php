<?php
/* @var $reviews \common\models\Review[] */
/* @var $reviewsWebpage \common\models\Webpage */
?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="text-center text-uppercase">Отзывы о нас</h2>
    </div>
</div>
<div class="row review-carousel-widget carousel-widget">
    <div class="col-xs-12">
        <div id="owl-carousel-6" class="owl-carousel owl-theme">
            <?php foreach ($reviews as $review): ?>
                <?= $this->render('/review/_block', ['review' => $review, 'grid' => false]); ?>
            <?php endforeach; ?>
        </div>
        <div id="carousel-nav-6" class="carousel-nav compact-carousel-nav">
            <a href="<?= Yii::$app->homeUrl . $reviewsWebpage->url; ?>" class="all-items-link">
                <span class="icon icon-reviews"></span>
                <span class="link-body">Все отзывы</span>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>