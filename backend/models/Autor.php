<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "autor".
 *
 * @property int $id_autor
 * @property int $nome_autor
 * @property int $id_pais
 *
 * @property Pais $pais
 * @property Livro[] $livros
 */
class Autor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome_autor', 'id_pais'], 'required'],
            [['nome_autor', 'id_pais'], 'integer'],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id_pais']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_autor' => 'Id Autor',
            'nome_autor' => 'Nome Autor',
            'id_pais' => 'Id Pais',
        ];
    }

    /**
     * Gets query for [[Pais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id_pais' => 'id_pais']);
    }

    /**
     * Gets query for [[Livros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivros()
    {
        return $this->hasMany(Livro::className(), ['id_autor' => 'id_autor']);
    }
}
