<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requisicao".
 *
 * @property int $id_requisicao
 * @property string $dta_levantamento
 * @property string $dta_entrega
 * @property string $estado
 * @property int $id_utilizador
 * @property int $id_bib_levantamento
 */
class Requisicao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisicao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['dta_levantamento', 'dta_entrega'], 'safe'],
            [['estado', 'id_utilizador'], 'required'],
            [['id_utilizador', 'id_bib_levantamento'], 'integer'],
            [['estado'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_requisicao' => 'Id Requisicao',
            //'dta_levantamento' => 'Dta Levantamento',
            //'dta_entrega' => 'Dta Entrega',
            'estado' => 'Estado',
            'id_utilizador' => 'Id Utilizador',
            'id_bib_levantamento' => 'Id Bib Levantamento',
        ];
    }
}
