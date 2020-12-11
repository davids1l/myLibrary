<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favorito".
 *
 * @property int $id_favorito
 * @property string $dta_favorito
 * @property int $id_livro
 * @property int $id_utilizador
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dta_favorito', 'id_livro', 'id_utilizador'], 'required'],
            [['dta_favorito'], 'safe'],
            [['id_livro', 'id_utilizador'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_favorito' => 'Id Favorito',
            'dta_favorito' => 'Data Fav',
            'id_livro' => 'Id Livro',
            'id_utilizador' => 'Id Utilizador',
        ];
    }
}
