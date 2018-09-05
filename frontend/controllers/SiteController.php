<?php
namespace frontend\controllers;

use common\models\Module;
use common\models\Page;
use common\models\Subject;
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'width' => 300,
                'height' => 100,
            ],
        ];
    }
    
    public function actionSitemap()
    {
        $urlArray = [Yii::$app->params['siteUrl']];

        /** @var Page[] $pages */
        $pages = Page::find()->where(['published' => Page::STATUS_ACTIVE])->with('webpage')->all();
        foreach ($pages as $page) {
            if (!$page->webpage->main) $urlArray[] = Yii::$app->params['siteUrl'] . '/' . $page->webpage->url;
        }

        /** @var Subject[] $subjects */
        $subjects = Subject::find()->where(['active' => Subject::STATUS_ACTIVE])->with('subjectPage.webpage')->all();
        foreach ($subjects as $subject) {
            if ($subject->subjectPage) $urlArray[] = Yii::$app->params['siteUrl'] . '/' . $subject->subjectPage->webpage->url;
        }

        $singlePages = [
            ['review', 'index'],
            ['teacher', 'index'],
            ['quiz', 'list'],
            ['high_school', 'index'],
            ['lyceum', 'index'],
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

        return $this->arrayToXml([['tag' => 'urlset', '@attributes' => ['xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9'], 'body' => $data]]);
    }

    /**
     * Получить xml из array
     *
     * @param array $array
     *
     * @return string
     */
    private function arrayToXml($array)
    {
        $xmlResult = '';
        foreach ($array as $key => $value) {
            if ($key === '@attributes' || $key === 'tag') continue;
            $xmlStruct = [];
            if (is_array($value) && array_key_exists('tag', $value)) $xmlStruct['tag'] = $value['tag'];
            else $xmlStruct['tag'] = $key;

            if (is_array($value)) {
                if (array_key_exists('@attributes', $value)) $xmlStruct['@attributes'] = $value['@attributes'];

                if (array_key_exists('body', $value)) {
                    if (is_array($value['body'])) $xmlStruct['body'] = self::arrayToXml($value['body']);
                    else $xmlStruct['body'] = $value['body'];
                } else {
                    $xmlStruct['body'] = self::arrayToXml($value);
                }
            } else {
                $xmlStruct['body'] = $value;
            }

            $propertiesString = '';
            if (array_key_exists('@attributes', $xmlStruct) && is_array($xmlStruct['@attributes'])) {
                foreach ($xmlStruct['@attributes'] as $attributeName => $attributeValue) {
                    $propertiesString .= ' ' . $attributeName . '="' . htmlspecialchars($attributeValue, ENT_QUOTES|ENT_HTML5, 'UTF-8') . '" ';
                }
            }
            $xmlResult .= '<' . $xmlStruct['tag'] . $propertiesString . ((!empty($xmlStruct['body']) || $xmlStruct['body'] === '0') ? '>' . $xmlStruct['body'] . '</' . $xmlStruct['tag'] . '>' : '/>');
        }
        return $xmlResult;
    }
}
