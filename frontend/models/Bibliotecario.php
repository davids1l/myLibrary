<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bibliotecario".
 *
 * @property int $id_bibliotecario
 * @property string $num_bibliotecario
 * @property int $id_biblioteca
 */
class Bibliotecario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bibliotecario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['num_bibliotecario', 'id_biblioteca'], 'required'],
            [['id_biblioteca'], 'integer'],
            [['num_bibliotecario'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_bibliotecario' => 'Id Bibliotecario',
            'num_bibliotecario' => 'Num Bibliotecario',
            'id_biblioteca' => 'Id Biblioteca',
        ];
    }
}
