<?php

namespace frontend\controllers;

use common\components\extended\Controller;
use common\models\Module;
use common\models\Subject;
use common\models\Webpage;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class SubjectController extends Controller
{
    /**
     * Displays a Subjects page.
     * @param $webpage Webpage
     * @return mixed
     */
    public function actionIndex($webpage)
    {
        $qB = Subject::getActiveListQuery();
        $itemsPerPage = 8;
        if (\Yii::$app->request->isAjax) {
            $subjects = $qB->limit($itemsPerPage)->offset(\Yii::$app->request->get('loaded'))->all();
            $output = '';
            $i = 0;
            foreach ($subjects as $subject) {
                $i++;
                $output .= $this->renderPartial('_block', ['subject' => $subject]);
                if ($i % 2 == 0) $output .= '<div class="clearfix"></div>';
            }
            return $output;
        } else {
            $subjectsTotal = $qB->count();
            return $this->render('index', [
                'subjects' => $qB->limit($itemsPerPage)->all(),
                'hasMore' => $subjectsTotal > $itemsPerPage,
                'webpage' => $webpage,
                'h1' => $webpage->title,
            ]);
        }
    }

    /**
     * Displays a single Subject model.
     * @param string $id
     * @param Webpage $webpage
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id, $webpage)
    {
        $subject = $this->findModel($id);
        return $this->render('view', [
            'subject' => $subject,
            'webpage' => $webpage,
            'h1' => $subject->name,
            'subjectsWebpage' => Webpage::findOne(['module_id' => Module::getModuleIdByControllerAndAction('subject', 'index')]),
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionList()
    {
        return $this->asJson(Subject::getActiveListQuery()->asArray(true)->select(['id', 'name'])->all());
    }

    /**
     * Finds the Subject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Subject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subject::findOne($id)) !== null && $model->active == Subject::STATUS_ACTIVE) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
