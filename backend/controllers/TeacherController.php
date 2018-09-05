<?php

namespace backend\controllers;

use backend\controllers\traits\Active;
use common\models\Module;
use common\models\Teacher;
use common\models\Webpage;
use yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * TeacherController implements the CRUD actions for Teacher model.
 */
class TeacherController extends AdminController
{
    use Active;

    protected $accessRule = 'manageTeachers';

    /**
     * Lists all Teacher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Teacher::find()->orderBy(['active' => SORT_DESC, 'name' => SORT_ASC]),
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
     * Creates a new Teacher model.
     * If creation is successful, the browser will be redirected to the 'page' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->processTeacherData(new Teacher());
    }

    /**
     * Updates an existing Teacher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        return $this->processTeacherData($this->findModel($id));
    }

    /**
     * @param Teacher $teacher
     * @return string|yii\web\Response
     * @throws \Exception
     */
    public function processTeacherData(Teacher $teacher)
    {
        if (Yii::$app->request->isPost) {
            $isNew = $teacher->isNewRecord;
            $transaction = Teacher::getDb()->beginTransaction();
            try {
                /*     Сохраняем учителя      */
                if (!$teacher->load(Yii::$app->request->post())) \Yii::$app->session->addFlash('error', 'Form data not found');
                else {
                    $teacher->photoFile = yii\web\UploadedFile::getInstance($teacher, 'photoFile');
                    if (!$teacher->save()) {
                        $teacher->moveErrorsToFlash();
                        $transaction->rollBack();
                    } else {
                        /*     Сохраняем картинку      */
                        if ($teacher->photoFile && (!$teacher->upload() || !$teacher->save(true, ['photo']))) {
                            \Yii::$app->session->addFlash('error', 'Unable to upload image');
                            $transaction->rollBack();
                        } else {
                            /*     Сохраняем страничку      */
                            if (!$teacher->webpage_id) {
                                $webpage = new Webpage();
                                $webpage->module_id = Module::getModuleIdByControllerAndAction('teacher', 'view');
                                $webpage->record_id = $teacher->id;
                            } else {
                                $webpage = $teacher->webpage;
                            }
                            if (!$webpage->load(Yii::$app->request->post())) {
                                \Yii::$app->session->addFlash('error', 'Form data not found');
                                $transaction->rollBack();
                            } elseif (!$webpage->save()) {
                                $webpage->moveErrorsToFlash();
                                $transaction->rollBack();
                            } else {
                                if (!$teacher->webpage_id) $teacher->link('webpage', $webpage);
                                $transaction->commit();
                                Yii::$app->session->addFlash('success', $isNew ? 'Учитель добавлен' : 'Учитель обновлён');
                                return $this->redirect(['update', 'id' => $teacher->id]);
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
            'teacher' => $teacher,
            'module' => Module::getModuleByControllerAndAction('teacher', 'view'),
        ]);
    }

    /**
     * @return string
     */
    public function actionPage()
    {
        $prefix = 'teacher_';
        $webpage = null;
        $moduleId = Module::getModuleIdByControllerAndAction('teacher', 'index');
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
                        $teacherId = str_replace($prefix, '', $data[$i - 1]);
                        $teacher = $this->findModel($teacherId);
                        $teacher->page_order = $i;
                        $teacher->save(true, ['page_order']);
                    }
                }
                Yii::$app->session->addFlash('success', 'Изменения сохранены');
                return $this->redirect(['page']);
            }
        }

        return $this->render('page', [
            'webpage' => $webpage,
            'teachers' => Teacher::find()->where(['active' => Teacher::STATUS_ACTIVE])->orderBy('page_order')->all(),
            'prefix' => $prefix,
        ]);
    }

    /**
     * Finds the Teacher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Teacher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Teacher::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
