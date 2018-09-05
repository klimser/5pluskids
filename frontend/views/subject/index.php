<?php

/* @var $this \yii\web\View */
/* @var $webpage common\models\Webpage */
/* @var $subjects \common\models\Subject[] */
/* @var $hasMore bool */

$this->params['breadcrumbs'][] = 'Курсы';
?>
<div class="row subject-index">
    <?php
    $i = 0;
    foreach ($subjects as $subject):
        $i++;
    ?>
        <?= $this->render('/subject/_block', ['subject' => $subject]); ?>

        <?php if ($i % 2 == 0): ?>
            <div class="clearfix"></div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php if ($hasMore): ?>
    <div class="row">
        <div class="col-xs-12 more-block">
            <a href="<?= Yii::$app->homeUrl . $webpage->url; ?>" onclick="return Main.loadMore(this, '.subject-index', '.subject-item');">
                <span class="icon icon-more"></span>
                <span class="link-body">Ещё курсы</span>
            </a>
        </div>
    </div>
<?php endif; ?>