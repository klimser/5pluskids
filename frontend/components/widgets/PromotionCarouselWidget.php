<?php

namespace frontend\components\widgets;

use common\models\Module;
use common\models\Promotion;
use common\models\Webpage;
use yii\base\Widget;

class PromotionCarouselWidget extends Widget
{
    public function run()
    {
        return $this->render('promotion-carousel', [
            'promotions' => Promotion::getActiveListQuery()->limit(5)->all(),
            'promotionsWebpage' => Webpage::find()->where(['module_id' => Module::getModuleIdByControllerAndAction('promotion', 'index')])->one(),
        ]);
    }
}