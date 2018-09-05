<?php

use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $page common\models\Page */
/* @var $webpage common\models\Webpage */
/* @var $reviews array */
/* @var $webpage \common\models\Webpage */

$this->registerJs('MainPage.init();');

unset($this->params['h1']);
?>
</div>
<div class="clouds-line-bottom hidden-xs hidden-sm" style="margin-top: -45px;"></div>
<div class="light-block after-kdpv">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?= $page->content; ?>

                <?= \frontend\components\widgets\SubjectCarouselWidget::widget(); ?>
                <hr>
                <?= \frontend\components\widgets\SubjectAgeCarouselWidget::widget(); ?>
            </div>
        </div>
    </div>
</div>
<div class="clouds-line-top"></div>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= \frontend\components\widgets\PromotionCarouselWidget::widget(); ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?= \frontend\components\widgets\NewsCarouselWidget::widget(); ?>
        </div>
    </div>
</div>

<div class="clouds-line-bottom"></div>
<div class="light-block">
    <div class="container">
        <?= \frontend\components\widgets\TeacherCarouselWidget::widget(); ?>
    </div>
</div>
<div class="clouds-line-top"></div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?= \frontend\components\widgets\ReviewCarouselWidget::widget(); ?>
        </div>
    </div>
</div>

<div id="order_form" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= Html::beginForm(\yii\helpers\Url::to(['order/create']), 'post', ['onsubmit' => 'return MainPage.completeOrder(this);']); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                    <h4 class="modal-title">Записаться на курс</h4>
                </div>
                <div class="modal-body">
                    <div id="order_form_body">
                        <input type="hidden" name="order[type]" value="">
                        <div class="form-group">
                            <label for="order-name">Ваше имя</label>
                            <input name="order[name]" id="order-name" class="form-control" required minlength="2" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="order-subject">Предмет</label>
                            <select name="order[subject]" id="order-subject" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="order-phone">Ваш номер телефона</label>
                            <div class="input-group"><span class="input-group-addon">+998</span>
                                <input type="tel" name="order[phoneFormatted]" id="order-phone" class="form-control" maxlength="11" pattern="\d{2} \d{3}-\d{4}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order-comment">Дополнительные сведения, пожелания</label>
                            <textarea name="order[user_comment]" id="order-comment" class="form-control" maxlength="255"></textarea>
                        </div>
                        <?= \himiklab\yii2\recaptcha\ReCaptcha::widget(['name' => 'order[reCaptcha]']) ?>
                    </div>
                    <div id="order_form_extra" class="hidden"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">отмена</button>
                    <button class="btn btn-primary">записаться</button>
                </div>
            <?= Html::endForm(); ?>
        </div>
    </div>
</div>
<div>