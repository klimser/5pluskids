<?php

namespace common\models;

use common\components\extended\ActiveRecord;
use yii;

/**
 * This is the model class for table "{{%widget_menu_item}}".
 *
 * @property string $id
 * @property integer $menu_id
 * @property integer $parent_id
 * @property integer $webpage_id
 * @property string $url
 * @property string $title
 * @property integer $active
 * @property string $attr
 * @property integer $orderby
 *
 * @property Webpage $webpage
 * @property MenuItem $parent
 * @property MenuItem[] $menuItems
 * @property Menu $menu
 */
class MenuItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_menu_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id'], 'required'],
            [['menu_id', 'parent_id', 'webpage_id', 'active', 'orderby'], 'integer'],
            [['attr'], 'string'],
            [['url'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 127],
            [['url', 'title', 'attr'], 'safe'],

            ['active', 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Меню',
            'parent_id' => 'Родительский пункт меню',
            'webpage_id' => 'Ссылка на страницу сайта',
            'url' => 'URL',
            'title' => 'Текст пункта меню',
            'active' => 'Показывать или нет',
            'attr' => 'Доп параметры',
            'orderby' => 'Порядок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebpage()
    {
        return $this->hasOne(Webpage::class, ['id' => 'webpage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::class, ['parent_id' => 'id'])->orderBy('orderby');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }
}
