<?php

namespace frontend\models;

use app\models\Requisicao;
use Yii;

/**
 * This is the model class for table "multa".
 *
 * @property int $id_multa
 * @property string $dta_multa
 * @property float $montante
 * @property string $estado
 * @property int $id_requisicao
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
            [['montante', 'estado', 'id_requisicao'], 'required'],
            [['montante'], 'number'],
            [['estado'], 'string', 'max' => 30],
            [['id_requisicao'], 'exist', 'skipOnError' => true, 'targetClass' => Requisicao::className(), 'targetAttribute' => ['id_requisicao' => 'id_requisicao']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_multa' => 'Id Multa',
            'dta_multa' => 'Data Multa',
            'montante' => 'Montante',
            'estado' => 'Estado',
            'id_requisicao' => 'Id Requisição'
        ];
    }
}
