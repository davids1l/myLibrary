<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "multa".
 *
 * @property int $id_multa
 * @property string $data_multa
 * @property float $montante
 * @property string $estado
 */
class Multa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'multa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_multa'], 'safe'],
            [['montante', 'estado'], 'required'],
            [['montante'], 'number'],
            [['estado'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_multa' => 'Id Multa',
            'data_multa' => 'Data Multa',
            'montante' => 'Montante',
            'estado' => 'Estado',
        ];
    }
}
