<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentario".
 *
 * @property int $id_comentario
 * @property string $dta_comentario
 * @property string $comentario
 * @property int $id_livro
 * @property int $id_utilizador
 *
 * @property Livro $livro
 * @property Utilizador $utilizador
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dta_comentario'], 'safe'],
            [['comentario', 'id_livro', 'id_utilizador'], 'required'],
            [['id_livro', 'id_utilizador'], 'integer'],
            [['comentario'], 'string', 'max' => 245],
            [['id_livro'], 'exist', 'skipOnError' => true, 'targetClass' => Livro::className(), 'targetAttribute' => ['id_livro' => 'id_livro']],
            [['id_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::className(), 'targetAttribute' => ['id_utilizador' => 'id_utilizador']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_comentario' => 'Id Comentario',
            'dta_comentario' => 'Dta Comentario',
            'comentario' => 'Comentario',
            'id_livro' => 'Id Livro',
            'id_utilizador' => 'Id Utilizador',
        ];
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
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(Utilizador::className(), ['id_utilizador' => 'id_utilizador']);
    }
}
