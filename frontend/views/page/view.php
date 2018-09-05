<?php

/* @var $this \yii\web\View */
/* @var $page common\models\Page */
/* @var $webpage common\models\Webpage */
/* @var $feedback \common\models\Feedback */
/* @var $reviews array */

if ($webpage->main):
    echo $this->render('main', ['page' => $page, 'webpage' => $webpage]);
else:
    $this->params['breadcrumbs'][] = $page->title;

    if ($webpage->url == \common\models\Feedback::PAGE_URL): ?>
        <div class="row">
            <div class="col-xs-12">
                <?= $page->content; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="text-uppercase">Если у вас есть вопросы, вы можете обратиться к нам:</h4>
                <?= $this->render('feedback-form'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2748.7532067591465!2d69.27403178911082!3d41.29718688503455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8bcb22c78dab%3A0x3ce3c96761c811fd!2zIjUrIEtJRFMiINCe0LnQsdC10Lo!5e0!3m2!1sru!2sru!4v1532685621585" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-xs-12 text-content">
                <?= $page->content; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>