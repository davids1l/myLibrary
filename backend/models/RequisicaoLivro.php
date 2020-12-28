<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requisicao_livro".
 *
 * @property int $id_livro
 * @property int $id_requisicao
 *
 * @property Livro $livro
 * @property Requisicao $requisicao
 */
class RequisicaoLivro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisicao_livro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_livro', 'id_requisicao'], 'required'],
            [['id_livro', 'id_requisicao'], 'integer'],
            [['id_livro', 'id_requisicao'], 'unique', 'targetAttribute' => ['id_livro', 'id_requisicao']],
            [['id_livro'], 'exist', 'skipOnError' => true, 'targetClass' => Livro::className(), 'targetAttribute' => ['id_livro' => 'id_livro']],
            [['id_requisicao'], 'exist', 'skipOnError' => true, 'targetClass' => Requisicao::className(), 'targetAttribute' => ['id_requisicao' => 'id_requisicao']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_livro' => 'Id Livro',
            'id_requisicao' => 'Id Requisicao',
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
     * Gets query for [[Requisicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicao()
    {
        return $this->hasOne(Requisicao::className(), ['id_requisicao' => 'id_requisicao']);
    }
}
