<?php

namespace backend\controllers;

use backend\controllers\traits\Active;
use backend\models\User;
use backend\models\UserSearch;
use common\models\Webpage;
use yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class UserController extends AdminController
{
    use Active;

    /**
     * Lists all User models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('manageUsers')) throw new ForbiddenHttpException('Access denied!');

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'isRoot' => Yii::$app->user->identity->role == User::ROLE_ROOT,
        ]);
    }

    /**
     * Creates a new Employee.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws \Exception
     * @throws yii\db\Exception
     */
    public function actionCreateEmployee()
    {
        if (!Yii::$app->user->can('manageEmployees')) throw new ForbiddenHttpException('Access denied!');

        $employee = new User();

        if (Yii::$app->request->isPost) {
            $employee->load(Yii::$app->request->post());
            $employee->active = User::STATUS_ACTIVE;
            $employee->setPassword($employee->password);
            $employee->generateAuthKey();

            if ($employee->save()) {
                Yii::$app->session->addFlash('success', 'Сотрудник добавлен');

                return $this->redirect(['update', 'id' => $employee->id]);
            } else {
                $employee->moveErrorsToFlash();
            }
        }

        return $this->render('create-employee', [
            'user' => $employee,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id = null)
    {
        $userToEdit = $id ?: Yii::$app->user->id;
        if (!Yii::$app->user->can('editUser', ['user' => $userToEdit])) throw new ForbiddenHttpException('Access denied!');

        $user = $this->findModel($userToEdit);

        if (Yii::$app->request->isPost) {
            if ($user->load(Yii::$app->request->post())) {
                $fields = null;
                if (Yii::$app->user->identity->role != User::ROLE_ROOT) $fields = ['username', 'password'];
                if ($user->save(true, $fields)) {
                    Yii::$app->session->addFlash('success', 'Успешно обновлено');
                    return $this->redirect(['update', 'id' => $id]);
                } else {
                    $user->moveErrorsToFlash();
                }
            } else \Yii::$app->session->addFlash('error', 'Внутренняя ошибка сервера');
        }

        return $this->render('update', [
            'user' => $user,
            'isAdmin' => Yii::$app->user->can('manageEmployees'),
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}