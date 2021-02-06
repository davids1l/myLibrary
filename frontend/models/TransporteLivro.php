<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transporte_livro".
 *
 * @property int $id_transporte
 * @property int $id_livro
 *
 * @property Transporte $transporte
 * @property Livro $livro
 * @property Transporte $transporte0
 */
class TransporteLivro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transporte_livro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transporte', 'id_livro'], 'required'],
            [['id_transporte', 'id_livro'], 'integer'],
            [['id_transporte', 'id_livro'], 'unique', 'targetAttribute' => ['id_transporte', 'id_livro']],
            [['id_transporte'], 'exist', 'skipOnError' => true, 'targetClass' => Transporte::className(), 'targetAttribute' => ['id_transporte' => 'id_transporte']],
            [['id_livro'], 'exist', 'skipOnError' => true, 'targetClass' => Livro::className(), 'targetAttribute' => ['id_livro' => 'id_livro']],
            [['id_transporte'], 'exist', 'skipOnError' => true, 'targetClass' => Transporte::className(), 'targetAttribute' => ['id_transporte' => 'id_transporte']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_transporte' => 'Id Transporte',
            'id_livro' => 'Id Livro',
        ];
    }

    /**
     * Gets query for [[Transporte]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransporte()
    {
        return $this->hasOne(Transporte::className(), ['id_transporte' => 'id_transporte']);
    }

    /**
     * Gets query for [[Livro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivro()
    {
        return $this->hasOne(Livro::className(), ['id_livro' => 'id_livro']);
    }

    /**
     * Gets query for [[Transporte0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransporte0()
    {
        return $this->hasOne(Transporte::className(), ['id_transporte' => 'id_transporte']);
    }
}
