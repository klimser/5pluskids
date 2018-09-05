<?php

namespace frontend\components\widgets;


use common\models\Subject;
use yii\base\Widget;

class SubjectCarouselWidget extends Widget
{
    public function run()
    {
        return $this->render('subject-carousel', ['subjects' => Subject::getActiveList()]);
    }
}