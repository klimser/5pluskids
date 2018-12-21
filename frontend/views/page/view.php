<?php

use common\components\WidgetHtml;

/* @var $this \yii\web\View */
/* @var $page common\models\Page */
/* @var $webpage common\models\Webpage */
/* @var $feedback \common\models\Feedback */
/* @var $reviews array */

if ($webpage->main):
    echo $this->render('main', ['page' => $page, 'webpage' => $webpage]);
else:
    $this->params['breadcrumbs'][] = $page->title;
?>

    <div class="row">
        <div class="col-xs-12">
            <?= $page->content; ?>
        </div>
    </div>

    <?php if ($webpage->url == \common\models\Feedback::PAGE_URL): ?>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="text-uppercase">Если у вас есть вопросы, вы можете обратиться к нам:</h4>
                <?= $this->render('feedback-form'); ?>
            </div>
        </div>
        <?= WidgetHtml::getByName('contacts_map'); ?>
    <?php elseif ($webpage->url == 'branches'): ?>
        <?= WidgetHtml::getByName('branches_map'); ?>
    <?php endif; ?>
<?php endif; ?>