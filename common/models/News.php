<?php
namespace common\models;
use common\components\extended\ActiveRecord;
use common\models\traits\Inserted;
use common\models\traits\UploadImage;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%module_news}}".
 *
 * @property int $id ID предмета
 * @property string $name Заголовок
 * @property string $image Картинка
 * @property string $description Тизер
 * @property string $content Контент
 * @property int $webpage_id ID страницы
 * @property int $active Активен
 * @property string $created_at Дата новости
 *
 * @property Webpage $webpage
 */
class News extends ActiveRecord
{
    use Inserted, UploadImage;

    /**
     * @return array
     */
    public function getUploadImageConfig(): array
    {
        return [
            'neededImageWidth' => 350,
            'neededImageHeight' => 0,
            'imageFolder' => 'news',
            'imageDBField' => 'image',
            'imageFilenameBase' => 'name',
            'imageFilenameAppendix' => 'id',
        ];
    }

    /** @var UploadedFile */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%module_news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
            [['content'], 'string'],
            [['webpage_id', 'active'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'checkExtensionByMimeType' => true],
            [['imageFile'], 'required', 'when' => function ($model, $attribute) {return $model->isNewRecord;}, 'whenClient' => "function (attribute, value) {
                return !$(attribute.input).data(\"id\");
            }"],
            [['webpage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webpage::class, 'targetAttribute' => ['webpage_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID предмета',
            'name' => 'Заголовок',
            'imageFile' => 'Картинка (350x225)',
            'content' => 'Контент',
            'webpage_id' => 'ID страницы',
            'active' => 'Активна',
            'created_at' => 'Дата новости',
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
     * @return ActiveQuery
     */
    public static function getActiveListQuery()
    {
        return self::find()->where(['active' => self::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return Subject[]
     */
    public static function getActiveList()
    {
        return self::getActiveListQuery()->all();
    }
}
