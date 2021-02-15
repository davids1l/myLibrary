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
 * @property Pais $pais
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
            [['designacao', 'id_pais'], 'required', 'message' => '{attribute} não pode estar em branco'],
            [['id_pais'], 'integer'],
            [['designacao'], 'string', 'max' => 80],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id_pais']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_editora' => 'Id Editora',
            'designacao' => 'Designação',
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
        return $this->hasMany(Livro::className(), ['id_editora' => 'id_editora']);
    }
}
