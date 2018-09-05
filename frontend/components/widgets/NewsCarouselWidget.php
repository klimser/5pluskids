<?php

namespace frontend\components\widgets;

use common\models\Module;
use common\models\News;
use common\models\Webpage;
use yii\base\Widget;

class NewsCarouselWidget extends Widget
{
    public function run()
    {
        return $this->render('news-carousel', [
            'news' => News::getActiveListQuery()->limit(5)->all(),
            'newsWebpage' => Webpage::find()->where(['module_id' => Module::getModuleIdByControllerAndAction('news', 'index')])->one(),
        ]);
    }
}