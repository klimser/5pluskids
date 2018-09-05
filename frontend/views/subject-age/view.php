<?php

/* @var $this \yii\web\View */
/* @var $subject common\models\SubjectAge */
/* @var $webpage common\models\Webpage */
/* @var $subjectsWebpage common\models\Webpage */

$this->params['breadcrumbs'][] = ['url' => Yii::$app->homeUrl . $subjectsWebpage->url, 'label' => 'Курсы по возрасту'];
$this->params['breadcrumbs'][] = $subject->name;
?>

<div class="row">
    <div class="col-xs-12 text-content">
        <?php if ($subject->image): ?>
            <img src="<?= $subject->imageUrl; ?>" class="pull-left max-width-50 top-left">
        <?php endif; ?>
        <?= $subject->content; ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 subject-index">
        <div class="title-separator">Другие курсы</div>
        <div class="row">
            <?= \frontend\components\widgets\RandomSubjectAgeWidget::widget(['exceptSubject' => $subject->id]); ?>
        </div>
    </div>
</div>