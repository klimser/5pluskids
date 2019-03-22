<?php

namespace common\models;

use common\components\extended\ActiveRecord;
use common\models\traits\UploadImage;
use yii;

/**
 * This is the model class for table "{{%module_teacher}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string|null $photo
 * @property string $shortName
 * @property string $officialName
 * @property string $webpage_id
 * @property integer $active
 * @property integer $page_order
 * @property string $noPhotoUrl
 *
 * @property Webpage $webpage
 */
class Teacher extends ActiveRecord
{
    use UploadImage {
        upload as protected uploadBasic;
    }

    /**
     * @return array
     */
    public function getUploadImageConfig(): array
    {
        return [
            'neededImageWidth' => 188,
            'neededImageHeight' => 188,
            'imageFolder' => 'teacher',
            'imageDBField' => 'photo',
            'imageFilenameBase' => 'name',
            'imageFilenameAppendix' => 'id',
            'skipTinify' => true,
        ];
    }

    private $_shortName;
    private $_officialName;

    /** @var yii\web\UploadedFile */
    public $photoFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module_teacher}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 127],
            [['title', 'photo'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'checkExtensionByMimeType' => true],
            [['active', 'page_order'], 'integer'],
            [['active'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['active'], 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО учителя',
            'title' => 'Специализация учителя',
            'description' => 'Текст об учителе',
            'photoFile' => 'Фото учителя (376x376)',
            'active' => 'Опубликован',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebpage()
    {
        return $this->hasOne(Webpage::class, ['id' => 'webpage_id']);
    }

    public function getShortName()
    {
        if ($this->_shortName === null) {
            $officialName = $this->officialName;
            $arr = explode(' ', $officialName);
            if (count($arr) > 1) {
                for ($i = 1; $i < count($arr); $i++) {
                    $arr[$i] = mb_strtoupper(mb_substr($arr[$i], 0, 1, 'UTF-8'), 'UTF-8') . '.';
                }
            }
            $this->_shortName = implode(' ', $arr);
        }
        return $this->_shortName;
    }

    public function getOfficialName()
    {
        if ($this->_officialName === null) {
            $name = $this->name;
            $arr = explode(' ', $name);
            if (count($arr) > 1) {
                $this->_officialName = $arr[1];
                if (count($arr) > 2) $this->_officialName .= ' ' . $arr[2];
            } else {
                $this->_officialName = $arr[0];
            }
        }
        return $this->_officialName;
    }

    /**
     * @param $imagePath
     * @param $maskPath
     * @param $framePath
     * @return string
     */
    private function addPhotoFrame(string $imagePath, string $maskPath, string $framePath): string
    {
        $arr = explode('.', $imagePath);
        $arr[count($arr) - 1] = 'png';
        $fileName = implode('.', $arr);

        if (class_exists('\Imagick')) {
            $base = new \Imagick($imagePath);
            $mask = new \Imagick($maskPath);
            $over = new \Imagick($framePath);

            $base->setImageFormat('png');
            $base->setImageColorspace($over->getImageColorspace());
            $base->setImageAlphaChannel(\Imagick::ALPHACHANNEL_ACTIVATE);

            $base->compositeImage($mask, \Imagick::COMPOSITE_DSTIN, 0, 0, \Imagick::CHANNEL_ALPHA);
            $base->borderImage(new \ImagickPixel('rgba(0, 0, 0, 0)'), ($over->getImageWidth() - $base->getImageWidth()) / 2,($over->getImageHeight() - $base->getImageHeight()) / 2);
            $base->compositeImage($over, \Imagick::COMPOSITE_DEFAULT, 0, 0);
            $base->writeImage($fileName);

            /** @var \Tinify\Source $source */
            $source = \Yii::$app->tinifier->getFromFile($fileName);
            $source->toFile($fileName);
        } elseif (extension_loaded('gd') && function_exists('gd_info')) {
            $baseInfo = getimagesize($imagePath);
            if ($baseInfo[2] == IMAGETYPE_PNG) $base = imagecreatefrompng($imagePath);
            else $base = imagecreatefromjpeg($imagePath);
            $mask = imagecreatefrompng($maskPath);
            $over = imagecreatefrompng($framePath);
            $overInfo = getimagesize($framePath);

            $xOffset = ($overInfo[0] - $baseInfo[0]) / 2 - round($overInfo[0] / 188);
            $yOffset = ($overInfo[1] - $baseInfo[1]) / 2 - round($overInfo[1] / 188);

            $newPicture = imagecreatetruecolor($overInfo[0], $overInfo[1]);
            imagesavealpha( $newPicture, true );
            imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );

            for($x = 0; $x < $baseInfo[0]; $x++) {
                for($y = 0; $y < $baseInfo[1]; $y++) {
                    $alpha = imagecolorsforindex($mask, imagecolorat($mask, $x, $y));
                    $color = imagecolorsforindex($base, imagecolorat($base, $x, $y));

                    if ($alpha['alpha'] < 127) {
                        imagesetpixel($newPicture, $xOffset + $x, $yOffset + $y, imagecolorallocatealpha($newPicture, $color['red'], $color['green'], $color['blue'], $alpha['alpha']));
                    }
                }
            }

            imagealphablending($newPicture, true);
            imagecopy($newPicture, $over, 0, 0, 0, 0, $overInfo[0], $overInfo[1]);
            imagepng($newPicture, $fileName);

            $source = \Tinify\fromFile($fileName);
            $source->toFile($fileName);
        } else {
            $arr = explode('/', $imagePath);
            return end($arr);
        }

        if ($imagePath != $fileName) unlink($imagePath);
        $arr = explode('/', $fileName);
        return end($arr);
    }

    /**
     * @param array $config
     * @return bool
     */
    public function upload($config = [])
    {
        if ($this->uploadBasic($config)) {
            $config = $this->getUploadImageConfig();
            $imageField = $config['imageDBField'];

            $imagePath = \Yii::getAlias('@uploads/' . $config['imageFolder']) . '/' . $this->$imageField;
            $arr = explode('.', $this->$imageField);
            $arr[count($arr) - 2] .= '@2x';
            $imagePath2x = \Yii::getAlias('@uploads/' . $config['imageFolder']) . '/' . implode('.', $arr);

            if (is_file($imagePath)) {
                $maskPath = \Yii::getAlias('@app/extra') . '/teacher_mask.png';
                $framePath = \Yii::getAlias('@app/extra') . '/teacher_frame.png';
                $this->$imageField = $this->addPhotoFrame($imagePath, $maskPath, $framePath);
            }

            if (is_file($imagePath2x)) {
                $maskPath = \Yii::getAlias('@app/extra') . '/teacher_mask@2x.png';
                $framePath = \Yii::getAlias('@app/extra') . '/teacher_frame@2x.png';
                $this->addPhotoFrame($imagePath2x, $maskPath, $framePath);
            }

            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getNoPhotoUrl()
    {
        $config = $this->getUploadImageConfig();
        return \Yii::getAlias('@uploadsUrl') . '/' . $config['imageFolder'] . '/no_photo.png';
    }

    /**
     * @return yii\db\ActiveQuery
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