<?php

namespace app\models;

use Carbon\Carbon;
use Yii;

/**
 * This is the model class for table "comentario".
 *
 * @property int $id_comentario
 * @property string $dta_comentario
 * @property string $comentario
 * @property int $id_livro
 * @property int $id_utilizador
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


    //função para criar um novo comentário -> *não utilizada*
    public function comentar($id_livro, $comment)
    {
        $comentario = new Comentario();

        $comentario->dta_comentario = Carbon::now();
        $comentario->comentario = $comment; //receber o comentario pelo post
        $comentario->id_livro = $id_livro;
        $comentario->id_utilizador = 1;

        return $comentario->save();
    }

}
