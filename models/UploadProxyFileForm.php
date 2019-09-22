<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadProxyFileForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions'=>['csv'], 'checkExtensionByMimeType'=>false],
        ];
    }

    /**
     * @return bool|string
     */
    public function getUploadDir()
    {
        return Yii::getAlias('@webroot/uploads/');
    }

    /**
     * @return string
     */
    public function getUploadFullFileName()
    {
        return $this->getUploadDir() . $this->imageFile->name;
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs($this->getUploadDir() . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}