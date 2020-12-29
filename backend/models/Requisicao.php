<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requisicao".
 *
 * @property int $id_requisicao
 * @property string $dta_levantamento
 * @property string $dta_entrega
 * @property string $estado
 * @property int $id_utilizador
 * @property int $id_bib_levantamento
 *
 * @property Biblioteca $bibLevantamento
 * @property Utilizador $utilizador
 * @property RequisicaoLivro[] $requisicaoLivros
 * @property Livro[] $livros
 * @property RequisicaoMulta $requisicaoMulta
 */
class Requisicao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisicao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dta_levantamento', 'dta_entrega', 'estado', 'id_utilizador', 'id_bib_levantamento'], 'required'],
            [['dta_levantamento', 'dta_entrega'], 'safe'],
            [['id_utilizador', 'id_bib_levantamento'], 'integer'],
            [['estado'], 'string', 'max' => 30],
            [['id_bib_levantamento'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::className(), 'targetAttribute' => ['id_bib_levantamento' => 'id_biblioteca']],
            [['id_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizador::className(), 'targetAttribute' => ['id_utilizador' => 'id_utilizador']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_requisicao' => 'Id Requisicao',
            'dta_levantamento' => 'Dta Levantamento',
            'dta_entrega' => 'Dta Entrega',
            'estado' => 'Estado',
            'id_utilizador' => 'Id Utilizador',
            'id_bib_levantamento' => 'Id Bib Levantamento',
        ];
    }

    /**
     * Gets query for [[BibLevantamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBibLevantamento()
    {
        return $this->hasOne(Biblioteca::className(), ['id_biblioteca' => 'id_bib_levantamento']);
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

    /**
     * Gets query for [[RequisicaoLivros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaoLivros()
    {
        return $this->hasMany(RequisicaoLivro::className(), ['id_requisicao' => 'id_requisicao']);
    }

    /**
     * Gets query for [[Livros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivros()
    {
        return $this->hasMany(Livro::className(), ['id_livro' => 'id_livro'])->viaTable('requisicao_livro', ['id_requisicao' => 'id_requisicao']);
    }

    /**
     * Gets query for [[RequisicaoMulta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaoMulta()
    {
        return $this->hasOne(RequisicaoMulta::className(), ['id_requisicao' => 'id_requisicao']);
    }
}
