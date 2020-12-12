<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pais".
 *
 * @property int $id_pais
 * @property string $designacao
 *
 * @property Autor[] $autors
 * @property Editora[] $editoras
 */
class Pais extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designacao'], 'required'],
            [['designacao'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pais' => 'Id Pais',
            'designacao' => 'Designacao',
        ];
    }

    /**
     * Gets query for [[Autors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutors()
    {
        return $this->hasMany(Autor::className(), ['id_pais' => 'id_pais']);
    }

    /**
     * Gets query for [[Editoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEditoras()
    {
        return $this->hasMany(Editora::className(), ['id_pais' => 'id_pais']);
    }
}
