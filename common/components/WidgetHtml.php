<?php

namespace common\components;

use yii\base\BaseObject;

class WidgetHtml extends BaseObject
{
    /**
     * @param \common\models\WidgetHtml|int|string $widget
     * @return string
     */
    private static function getCacheKey($widget)
    {
        if (is_int($widget)) $widget = \common\models\WidgetHtml::findOne($widget);
        $widgetName = '';
        if (is_string($widget)) $widgetName = $widget;
        elseif ($widget instanceof \common\models\WidgetHtml) $widgetName = $widget->name;
        return 'widget.html.' . $widgetName;
    }

    /**
     * @param string $name
     * @return mixed|string
     */
    public static function getByName(string $name)
    {
        if (empty($name)) return '';
        $widget = \Yii::$app->cache->getOrSet(self::getCacheKey($name), function() use ($name) {
            $widgetHtml = \common\models\WidgetHtml::findOne(['name' => $name]);
            return $widgetHtml ? $widgetHtml->content : '';
        });
        return $widget;
    }

    /**
     * @param \common\models\WidgetHtml $widget
     * @return bool
     */
    public static function clearCache(\common\models\WidgetHtml $widget)
    {
        return \Yii::$app->cache->delete(self::getCacheKey($widget));
    }
}