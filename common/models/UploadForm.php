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

    public function upload($numero, $pasta)
    {
        if ($this->validate()) {

            $this->imageFile->saveAs('../web/imgs/' . $pasta . '/' . $numero . '.' . $this->imageFile->extension);
            $this->imageFile->name = $numero . '.' . $this->imageFile->extension;
            return true;
        } else {
            return false;
        }
    }
}
