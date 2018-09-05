<?php

namespace frontend\components\widgets;


use common\models\Subject;
use common\models\Teacher;
use yii\base\Widget;

class TeacherSubjectWidget extends Widget
{
    /** @var  Teacher */
    public $teacher;
    public $teacherCount;

    public function init()
    {
        parent::init();
        if (!$this->teacherCount) $this->teacherCount = 4;
    }

    public function run()
    {
        $teachers = Teacher::find()
            ->andWhere(['active' => Subject::STATUS_ACTIVE, 'title' => $this->teacher->title])
            ->andWhere(['!=', 'id', $this->teacher->id])
            ->orderBy('rand()')->limit($this->teacherCount)->all();
        if (empty($teachers)) return '';

        return $this->render('teacher-subject', ['teachers' => $teachers]);
    }
}