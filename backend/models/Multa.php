<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "multa".
 *
 * @property int $id_multa
 * @property float $montante
 * @property string $estado
 * @property int $id_requisicao
 * @property string $dta_multa
 *
 * @property Requisicao $requisicao
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
            [['montante', 'estado', 'id_requisicao'], 'required'],
            [['montante'], 'number'],
            [['id_requisicao'], 'integer'],
            [['dta_multa'], 'safe'],
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
            'id_multa' => 'ID Multa',
            'montante' => 'Montante',
            'estado' => 'Estado',
            'id_requisicao' => 'ID Requisição',
            'dta_multa' => 'Data da Multa',
        ];
    }

    /**
     * Gets query for [[Requisicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicao()
    {
        return $this->hasOne(Requisicao::className(), ['id_requisicao' => 'id_requisicao']);
    }
}
