<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "editora".
 *
 * @property int $id_editora
 * @property string $designacao
 * @property int $id_pais
 *
 * @property Livro[] $livros
 */
class Editora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'editora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designacao', 'id_pais'], 'required'],
            [['id_pais'], 'integer'],
            [['designacao'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_editora' => 'Id Editora',
            'designacao' => 'Designacao',
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
        return $this->hasMany(Livro::className(), ['id_editora' => 'id_editora']);
    }
}
