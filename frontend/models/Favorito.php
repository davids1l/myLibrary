<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favorito".
 *
 * @property int $id_favorito
 * @property string $data_fav
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
            [['data_fav', 'id_livro', 'id_utilizador'], 'required'],
            [['data_fav'], 'safe'],
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
            'data_fav' => 'Data Fav',
            'id_livro' => 'Id Livro',
            'id_utilizador' => 'Id Utilizador',
        ];
    }
}
