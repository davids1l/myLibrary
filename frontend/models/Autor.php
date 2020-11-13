<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "autor".
 *
 * @property int $id_autor
 * @property string $nome_autor
 * @property int $id_pais
 *
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
            [['id_pais'], 'integer'],
            [['nome_autor'], 'string', 'max' => 80],
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
     * Gets query for [[Livros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivros()
    {
        return $this->hasMany(Livro::className(), ['id_autor' => 'id_autor']);
    }
}
