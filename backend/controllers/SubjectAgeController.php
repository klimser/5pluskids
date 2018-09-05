<?php

namespace backend\controllers;

use backend\controllers\traits\Active;
use common\models\Module;
use common\models\SubjectAge;
use common\models\Webpage;
use yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * SubjectAgeController implements the CRUD actions for SubjectAge model.
 */
class SubjectAgeController extends AdminController
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
            'query' => SubjectAge::find()->orderBy(['name' => SORT_ASC]),
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
        return $this->processSubjectData(new SubjectAge());
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
     * @param SubjectAge $subjectAge
     * @return string|yii\web\Response
     * @throws \Exception
     */
    public function processSubjectData(SubjectAge $subjectAge)
    {
        if (Yii::$app->request->isPost) {
            $isNew = $subjectAge->isNewRecord;
            $transaction = SubjectAge::getDb()->beginTransaction();
            try {
                /*     Сохраняем курс      */
                if (!$subjectAge->load(Yii::$app->request->post())) \Yii::$app->session->addFlash('error', 'Form data not found');
                else {
                    $subjectAge->imageFile = yii\web\UploadedFile::getInstance($subjectAge, 'imageFile');
                    $subjectAge->iconFile = yii\web\UploadedFile::getInstance($subjectAge, 'iconFile');
                    if (!$subjectAge->save()) {
                        $subjectAge->moveErrorsToFlash();
                        $transaction->rollBack();
                    } else {
                        /*     Сохраняем картинку      */
                        if (($isNew && !$subjectAge->iconFile)
                            || ($subjectAge->iconFile
                                && (!$subjectAge->upload($subjectAge->getUploadIconConfig()) || !$subjectAge->save(true, ['icon'])))) {
                            \Yii::$app->session->addFlash('error', 'Unable to upload icon');
                            $transaction->rollBack();
                        } elseif ($subjectAge->imageFile && (!$subjectAge->upload() || !$subjectAge->save(true, ['image']))) {
                            \Yii::$app->session->addFlash('error', 'Unable to upload image');
                            $transaction->rollBack();
                        } else {
                            /*     Сохраняем страничку      */
                            if (!$subjectAge->webpage_id) {
                                $webpage = new Webpage();
                                $webpage->module_id = Module::getModuleIdByControllerAndAction('subject-age', 'view');
                                $webpage->record_id = $subjectAge->id;
                            } else {
                                $webpage = $subjectAge->webpage;
                            }
                            if (!$webpage->load(Yii::$app->request->post())) {
                                \Yii::$app->session->addFlash('error', 'Form data not found');
                                $transaction->rollBack();
                            } elseif (!$webpage->save()) {
                                $webpage->moveErrorsToFlash();
                                $transaction->rollBack();
                            } else {
                                if (!$subjectAge->webpage_id) $subjectAge->link('webpage', $webpage);
                                $transaction->commit();
                                Yii::$app->session->addFlash('success', $isNew ? 'Курс добавлен' : 'Курс обновлён');
                                return $this->redirect(['update', 'id' => $subjectAge->id]);
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
            'subjectAge' => $subjectAge,
            'module' => Module::getModuleByControllerAndAction('subject-age', 'view'),
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
        $transaction = SubjectAge::getDb()->beginTransaction();
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
        $moduleId = Module::getModuleIdByControllerAndAction('subject-age', 'index');
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
            'subjects' => SubjectAge::find()->where(['active' => SubjectAge::STATUS_ACTIVE])->orderBy('page_order')->all(),
            'prefix' => $prefix,
        ]);
    }

    /**
     * Finds the Subject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SubjectAge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubjectAge::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested subject does not exist.');
        }
    }
}
