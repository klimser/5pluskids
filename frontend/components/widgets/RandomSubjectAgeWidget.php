<?php

namespace frontend\components\widgets;


use common\models\Subject;
use common\models\SubjectAge;
use yii\base\Widget;

class RandomSubjectAgeWidget extends Widget
{
    public $subjectCount;
    public $exceptSubject;

    public function init()
    {
        parent::init();
        if (!$this->subjectCount) $this->subjectCount = 4;
    }

    public function run()
    {
        $subjects = SubjectAge::find()
            ->andWhere(['active' => SubjectAge::STATUS_ACTIVE])
            ->andWhere(['!=', 'id', $this->exceptSubject])
            ->orderBy('rand()')->limit($this->subjectCount)->all();
        $output = '';
        $i = 0;
        foreach ($subjects as $subject) {
            $i++;
            $output .= $this->render('/subject-age/_block', ['subject' => $subject]);
            if ($i % 2 == 0) $output .= '<div class="clearfix"></div>';
        }
        return $output;
    }
}