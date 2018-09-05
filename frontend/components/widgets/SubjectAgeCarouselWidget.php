<?php

namespace frontend\components\widgets;


use common\models\SubjectAge;
use yii\base\Widget;

class SubjectAgeCarouselWidget extends Widget
{
    public function run()
    {
        return $this->render('subject-age-carousel', ['subjects' => SubjectAge::getActiveList()]);
    }
}