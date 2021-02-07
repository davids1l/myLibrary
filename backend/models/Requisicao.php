<?php

namespace app\models;

use Bluerhinos\phpMQTT;
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
            [['estado', 'id_utilizador', 'id_bib_levantamento'], 'required'],
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($this->estado === "Pronta a levantar") {

            $id_requisicao=$this->id_requisicao;
            $estado=$this->estado;
            $id_utilizador = $this->id_utilizador;
            $id_bib_levantamento = $this->id_bib_levantamento;

            /*$myObj = new \stdClass();
            $myObj->id_req = $id_requisicao;
            $myObj->estado = $estado;
            $myObj->id_utilizador = $id_utilizador;
            $myObj->biblioteca = $id_bib_levantamento;

            $myJson = json_encode($myObj);

            $topico = 'req/' . $id_requisicao;

            if($insert == false)
                $this->FazPublish($topico, $myJson);*/
        }
    }

    public function FazPublish($canal, $msg) {
        $server = "127.0.0.1";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = "phpMQTT-publisher".rand();
        $mqtt = new phpMQTT($server, $port, $client_id);
        if($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0, true);
            $mqtt->close();
        }
        else { file_put_contents("debug.output", "Time out!"); }
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
