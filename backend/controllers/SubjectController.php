<?php

namespace backend\controllers;

use backend\controllers\traits\Active;
use common\models\Module;
use common\models\Webpage;
use yii;
use common\models\Subject;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * SubjectController implements the CRUD actions for Subject model.
 */
class SubjectController extends AdminController
{
    use Active;

    protected $accessRule = 'manageSubjects';

    /**
     * Lists all Subject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Subject::find()->orderBy(['name' => SORT_ASC]),
            'pagination' => ['pageSize' => 50,],
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC],
                'attributes' => ['name'],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Subject model.
     * If creation is successful, the browser will be redirected to the 'page' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->processSubjectData(new Subject());
    }

    /**
     * Updates an existing Subject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        return $this->processSubjectData($this->findModel($id));
    }

    /**
     * @param Subject $subject
     * @return string|yii\web\Response
     * @throws \Exception
     */
    public function processSubjectData(Subject $subject)
    {
        if (Yii::$app->request->isPost) {
            $isNew = $subject->isNewRecord;
            $transaction = Subject::getDb()->beginTransaction();
            try {
                /*     Сохраняем курс      */
                if (!$subject->load(Yii::$app->request->post())) \Yii::$app->session->addFlash('error', 'Form data not found');
                else {
                    $subject->imageFile = yii\web\UploadedFile::getInstance($subject, 'imageFile');
                    $subject->iconFile = yii\web\UploadedFile::getInstance($subject, 'iconFile');
                    if (!$subject->save()) {
                        $subject->moveErrorsToFlash();
                        $transaction->rollBack();
                    } else {
                        /*     Сохраняем картинку      */
                        if (($isNew && !$subject->iconFile)
                            || ($subject->iconFile
                                && (!$subject->upload($subject->getUploadIconConfig()) || !$subject->save(true, ['icon'])))) {
                            \Yii::$app->session->addFlash('error', 'Unable to upload icon');
                            $transaction->rollBack();
                        } elseif ($subject->imageFile && (!$subject->upload() || !$subject->save(true, ['image']))) {
                            \Yii::$app->session->addFlash('error', 'Unable to upload image');
                            $transaction->rollBack();
                        } else {
                            /*     Сохраняем страничку      */
                            if (!$subject->webpage_id) {
                                $webpage = new Webpage();
                                $webpage->module_id = Module::getModuleIdByControllerAndAction('subject', 'view');
                                $webpage->record_id = $subject->id;
                            } else {
                                $webpage = $subject->webpage;
                            }
                            if (!$webpage->load(Yii::$app->request->post())) {
                                \Yii::$app->session->addFlash('error', 'Form data not found');
                                $transaction->rollBack();
                            } elseif (!$webpage->save()) {
                                $webpage->moveErrorsToFlash();
                                $transaction->rollBack();
                            } else {
                                if (!$subject->webpage_id) $subject->link('webpage', $webpage);
                                $transaction->commit();
                                Yii::$app->session->addFlash('success', $isNew ? 'Курс добавлен' : 'Курс обновлён');
                                return $this->redirect(['update', 'id' => $subject->id]);
                            }
                        }
                    }
                }
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'subject' => $subject,
            'module' => Module::getModuleByControllerAndAction('subject', 'view'),
        ]);
    }

    /**
     * Deletes an existing Subject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $subject = $this->findModel($id);
        $transaction = Subject::getDb()->beginTransaction();
        try {
            if (!$subject->delete()) {
                $subject->moveErrorsToFlash();
                $transaction->rollBack();
            } else {
                $transaction->commit();
            }
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $this->redirect(['index']);
    }

    /**
     * @return string
     */
    public function actionPage()
    {
        $prefix = 'subject_';
        $webpage = null;
        $moduleId = Module::getModuleIdByControllerAndAction('subject', 'index');
        $webpage = Webpage::find()->where(['module_id' => $moduleId])->one();
        if (!$webpage) {
            $webpage = new Webpage();
            $webpage->module_id = $moduleId;
        }

        if (Yii::$app->request->isPost) {
            if (!$webpage->load(Yii::$app->request->post())) {
                \Yii::$app->session->addFlash('error', 'Form data not found');
            } elseif (!$webpage->save()) {
                $webpage->moveErrorsToFlash();
            } else {
                $sortOrder = Yii::$app->request->post('sorted-list');
                if ($sortOrder) {
                    $data = explode(',', $sortOrder);
                    for ($i = 1; $i <= count($data); $i++) {
                        $subjectId = str_replace($prefix, '', $data[$i - 1]);
                        $subject = $this->findModel($subjectId);
                        $subject->page_order = $i;
                        $subject->save(true, ['page_order']);
                    }
                }
                Yii::$app->session->addFlash('success', 'Изменения сохранены');
                return $this->redirect(['page']);
            }
        }

        return $this->render('page', [
            'webpage' => $webpage,
            'subjects' => Subject::find()->where(['active' => Subject::STATUS_ACTIVE])->orderBy('page_order')->all(),
            'prefix' => $prefix,
        ]);
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
        if (($model = Subject::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested subject does not exist.');
        }
    }
}
