<?php


namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload($numero)
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('../web/imgs/perfil/' . $numero . '.' . $this->imageFile->extension);
            $this->imageFile->name = $numero . '.' . $this->imageFile->extension;
            return true;
        } else {
            return false;
        }
    }
}
