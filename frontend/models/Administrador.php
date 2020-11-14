<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "administrador".
 *
 * @property int $id_admin
 * @property string $num_admin
 */
class Administrador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'administrador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['num_admin'], 'required'],
            [['num_admin'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_admin' => 'Id Admin',
            'num_admin' => 'Num Admin',
        ];
    }
}
