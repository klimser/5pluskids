<?php

/* @var $this \yii\web\View */
/* @var $webpage common\models\Webpage */
/* @var $news \common\models\News[] */
/* @var $pager \yii\data\Pagination */

$this->params['breadcrumbs'][] = 'Новости';
?>
<div class="row news-index">
    <?php
    $i = 0;
    foreach ($news as $newsItem):
        $i++;
    ?>
        <?= $this->render('/news/_block', ['news' => $newsItem, 'grid' => true]); ?>

        <?php if ($i % 4 == 0): ?>
            <div class="clearfix"></div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<div class="text-center">
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $pager,
        'nextPageLabel' => '<span class="hidden-xs">Следующая страница</span> →',
        'prevPageLabel' => '← <span class="hidden-xs">Предыдущая страница</span>',
    ]); ?>
</div>
