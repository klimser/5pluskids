<?php

namespace frontend\controllers;

use common\components\extended\Controller;
use common\models\Webpage;
use common\models\Page;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    /**
     * Displays a single Page model.
     * @param string $id
     * @param $webpage Webpage
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id, $webpage)
    {
        $page = $this->findModel($id);
        if ($page->isActive()) {
            $params = [
                'page' => $page,
                'webpage' => $webpage,
                'h1' => $page->title,
            ];
            return $this->render('view', $params);
        } else {
            throw new NotFoundHttpException('Page is not exists');
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
