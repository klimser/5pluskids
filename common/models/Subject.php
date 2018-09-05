<?php

namespace common\models;

use common\components\extended\ActiveRecord;
use common\models\traits\UploadImage;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%subject}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $content
 * @property string $webpage_id
 * @property integer $active
 * @property integer $page_order
 * @property string $image
 * @property string $icon
 * @property string $iconUrl
 *
 * @property Webpage $webpage
 */
class Subject extends ActiveRecord
{
    use UploadImage;

    /**
     * @return array
     */
    public function getUploadImageConfig(): array
    {
        return [
            'neededImageWidth' => 484,
            'neededImageHeight' => 0,
            'imageFolder' => 'subject',
            'imageDBField' => 'image',
            'imageFilenameBase' => 'name',
            'imageFilenameAppendix' => 'id',
            'onDelete' => ['getUploadImageConfig', 'getUploadIconConfig'],
        ];
    }

    /**
     * @return array
     */
    public function getUploadIconConfig(): array
    {
        return [
            'mandatory2x' => true,
            'neededImageWidth' => 160,
            'neededImageHeight' => 125,
            'imageFolder' => 'subject/icon',
            'imageDBField' => 'icon',
            'imageFilenameBase' => 'name',
            'imageFilenameAppendix' => 'id',
        ];
    }

    /** @var UploadedFile */
    public $imageFile;
    /** @var UploadedFile */
    public $iconFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module_subject}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content', 'description'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['icon', 'image'], 'string', 'max' => 255],
            [['content', 'description'], 'string'],
            [['iconFile', 'imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'checkExtensionByMimeType' => true],
            [['iconFile'], 'required', 'when' => function ($model, $attribute) {return $model->isNewRecord;}, 'whenClient' => "function (attribute, value) {
                return !$(attribute.input).data(\"id\");
            }"],
            [['active', 'page_order'], 'integer'],
            [['active'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['content', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID курса',
            'name' => 'Название курса',
            'description' => 'Краткое описание',
            'content' => 'Содержимое страницы',
            'active' => 'Опубликован',
            'imageFile' => 'Картинка (min 484x309)',
            'iconFile' => 'Картинка для виджета (320x250)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebpage()
    {
        return $this->hasOne(Webpage::class, ['id' => 'webpage_id']);
    }

    public function getIconUrl()
    {
        return $this->getImageUrl($this->getUploadIconConfig());
    }

    /**
     * @return ActiveQuery
     */
    public static function getActiveListQuery()
    {
        return self::find()->where(['active' => self::STATUS_ACTIVE])->orderBy('page_order');
    }

    /**
     * @return Subject[]
     */
    public static function getActiveList()
    {
        return self::getActiveListQuery()->all();
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) return false;

        if ($this->webpage && !$this->webpage->delete()) {
            $this->webpage->moveErrorsToFlash();
            return false;
        }
        return true;
    }
}
