<?php
/* @var $promotions \common\models\Promotion[] */
/* @var $promotionsWebpage \common\models\Webpage */
?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="text-center text-uppercase">Акции</h2>
    </div>
</div>
<div class="row news-carousel-widget carousel-widget">
    <div class="col-xs-12">
        <div id="owl-carousel-5" class="owl-carousel owl-theme">
            <?php foreach ($promotions as $promotion): ?>
                <?= $this->render('/promotion/_block', ['promotion' => $promotion, 'grid' => false]); ?>
            <?php endforeach; ?>
        </div>
        <div id="carousel-nav-5" class="carousel-nav compact-carousel-nav">
            <a href="<?= Yii::$app->homeUrl . $promotionsWebpage->url; ?>" class="all-items-link">
                <span class="icon icon-offers"></span>
                <span class="link-body">Все акции</span>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>