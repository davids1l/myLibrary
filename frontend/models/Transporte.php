<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transporte".
 *
 * @property int $id_transporte
 * @property string $estado
 * @property int $id_bib_despacho
 * @property int $id_bib_recetora
 * @property string|null $dta_despacho
 * @property string|null $dta_recebida
 * @property int $id_requisicao
 *
 * @property Biblioteca $bibDespacho
 * @property Biblioteca $bibRecetora
 * @property Requisicao $requisicao
 * @property TransporteLivro[] $transporteLivros
 * @property TransporteLivro[] $transporteLivros0
 * @property Livro[] $livros
 * @property Livro[] $livros0
 */
class Transporte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transporte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado', 'id_bib_despacho', 'id_bib_recetora', 'id_requisicao'], 'required'],
            [['id_bib_despacho', 'id_bib_recetora', 'id_requisicao'], 'integer'],
            [['dta_despacho', 'dta_recebida'], 'safe'],
            [['estado'], 'string', 'max' => 30],
            [['id_bib_despacho'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::className(), 'targetAttribute' => ['id_bib_despacho' => 'id_biblioteca']],
            [['id_bib_recetora'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::className(), 'targetAttribute' => ['id_bib_recetora' => 'id_biblioteca']],
            [['id_requisicao'], 'exist', 'skipOnError' => true, 'targetClass' => Requisicao::className(), 'targetAttribute' => ['id_requisicao' => 'id_requisicao']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_transporte' => 'Id Transporte',
            'estado' => 'Estado',
            'id_bib_despacho' => 'Id Bib Despacho',
            'id_bib_recetora' => 'Id Bib Recetora',
            'dta_despacho' => 'Dta Despacho',
            'dta_recebida' => 'Dta Recebida',
            'id_requisicao' => 'Id Requisicao',
        ];
    }

    /**
     * Gets query for [[BibDespacho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBibDespacho()
    {
        return $this->hasOne(Biblioteca::className(), ['id_biblioteca' => 'id_bib_despacho']);
    }

    /**
     * Gets query for [[BibRecetora]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBibRecetora()
    {
        return $this->hasOne(Biblioteca::className(), ['id_biblioteca' => 'id_bib_recetora']);
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

    /**
     * Gets query for [[TransporteLivros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransporteLivros()
    {
        return $this->hasMany(TransporteLivro::className(), ['id_transporte' => 'id_transporte']);
    }

    /**
     * Gets query for [[TransporteLivros0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransporteLivros0()
    {
        return $this->hasMany(TransporteLivro::className(), ['id_transporte' => 'id_transporte']);
    }

    /**
     * Gets query for [[Livros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivros()
    {
        return $this->hasMany(Livro::className(), ['id_livro' => 'id_livro'])->viaTable('transporte_livro', ['id_transporte' => 'id_transporte']);
    }

    /**
     * Gets query for [[Livros0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivros0()
    {
        return $this->hasMany(Livro::className(), ['id_livro' => 'id_livro'])->viaTable('transporte_livro', ['id_transporte' => 'id_transporte']);
    }
}
