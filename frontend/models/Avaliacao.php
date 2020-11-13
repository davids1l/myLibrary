<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "avaliacao".
 *
 * @property int $id_avaliacao
 * @property string $data_avaliacao
 * @property int $avaliacao
 * @property int $id_livro
 * @property int $id_utilizador
 */
class Avaliacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_avaliacao'], 'safe'],
            [['avaliacao', 'id_livro', 'id_utilizador'], 'required'],
            [['avaliacao', 'id_livro', 'id_utilizador'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_avaliacao' => 'Id Avaliacao',
            'data_avaliacao' => 'Data Avaliacao',
            'avaliacao' => 'Avaliacao',
            'id_livro' => 'Id Livro',
            'id_utilizador' => 'Id Utilizador',
        ];
    }
}
