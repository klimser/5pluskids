<?php

namespace frontend\components\widgets;


use common\models\Subject;
use yii\base\Widget;

class RandomSubjectWidget extends Widget
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
        $subjects = Subject::find()
            ->andWhere(['active' => Subject::STATUS_ACTIVE])
            ->andWhere(['!=', 'id', $this->exceptSubject])
            ->orderBy('rand()')->limit($this->subjectCount)->all();
        $output = '';
        $i = 0;
        foreach ($subjects as $subject) {
            $i++;
            $output .= $this->render('/subject/_block', ['subject' => $subject]);
            if ($i % 2 == 0) $output .= '<div class="clearfix"></div>';
        }
        return $output;
    }
}