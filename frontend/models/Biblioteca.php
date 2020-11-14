<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "biblioteca".
 *
 * @property int $id_biblioteca
 * @property string $nome
 * @property string $cod_postal
 *
 * @property Livro[] $livros
 */
class Biblioteca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biblioteca';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'cod_postal'], 'required'],
            [['nome'], 'string', 'max' => 120],
            [['cod_postal'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_biblioteca' => 'Id Biblioteca',
            'nome' => 'Nome',
            'cod_postal' => 'Cod Postal',
        ];
    }

    /**
     * Gets query for [[Livros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivros()
    {
        return $this->hasMany(Livro::className(), ['id_biblioteca' => 'id_biblioteca']);
    }
}
