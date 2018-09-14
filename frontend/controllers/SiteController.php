<?php
namespace frontend\controllers;

use common\components\helpers\Xml;
use common\models\Module;
use common\models\Page;
use common\models\Subject;
use common\models\SubjectAge;
use common\models\Teacher;
use common\models\Webpage;
use yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    public function actionSitemap()
    {
        $urlArray = [Yii::$app->params['siteUrl']];

        /** @var Page[] $pages */
        $pages = Page::find()->where(['active' => Page::STATUS_ACTIVE])->with('webpage')->all();
        foreach ($pages as $page) {
            if (!$page->webpage->main) $urlArray[] = Yii::$app->params['siteUrl'] . '/' . $page->webpage->url;
        }

        /** @var Subject[] $subjects */
        $subjects = Subject::find()->where(['active' => Subject::STATUS_ACTIVE])->with('webpage')->all();
        foreach ($subjects as $subject) {
            $urlArray[] = Yii::$app->params['siteUrl'] . '/' . $subject->webpage->url;
        }

        /** @var Subject[] $subjects */
        $subjects = SubjectAge::find()->where(['active' => SubjectAge::STATUS_ACTIVE])->with('webpage')->all();
        foreach ($subjects as $subject) {
            $urlArray[] = Yii::$app->params['siteUrl'] . '/' . $subject->webpage->url;
        }

        /** @var Teacher[] $teachers */
        $teachers = Teacher::find()->where(['active' => Teacher::STATUS_ACTIVE])->with('webpage')->all();
        foreach ($teachers as $teacher) {
            $urlArray[] = Yii::$app->params['siteUrl'] . '/' . $teacher->webpage->url;
        }

        $singlePages = [
            ['subject', 'index'],
            ['subject-age', 'index'],
            ['review', 'index'],
            ['teacher', 'index'],
            ['news', 'index'],
            ['promotions', 'index'],
        ];

        foreach ($singlePages as $singlePage) {
            /** @var Webpage $webpage */
            $webpage = Webpage::find()->where(['module_id' => Module::getModuleIdByControllerAndAction($singlePage[0], $singlePage[1])])->one();
            if ($webpage && $webpage->url) $urlArray[] = Yii::$app->params['siteUrl'] . '/' . $webpage->url;
        }

        $data = [];
        foreach ($urlArray as $url) {
            $data[] = ['tag' => 'url', 'body' => ['loc' => $url]];
        }

        Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/xml');

        return Xml::arrayToXml([['tag' => 'urlset', '@attributes' => ['xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9'], 'body' => $data]]);
    }
}
