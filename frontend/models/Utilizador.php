<?php

namespace frontend\models;

use app\models\Administrador;
use app\models\Avaliacao;
use app\models\Bibliotecario;
use app\models\Comentario;
use app\models\Favorito;
use app\models\Requisicao;
use Carbon\Carbon;
use common\models\User;
use Yii;
use yii\db\Query;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "utilizador".
 *
 * @property int $id_utilizador
 * @property string $primeiro_nome
 * @property string $ultimo_nome
 * @property string $numero
 * @property int|null $bloqueado
 * @property string|null $dta_bloqueado
 * @property string $dta_nascimento
 * @property string $nif
 * @property int $num_telemovel
 * @property string $dta_registo
 * @property string $foto_perfil
 *
 * @property Avaliacao[] $avaliacaos
 * @property Bibliotecario $bibliotecario
 * @property Comentario[] $comentarios
 * @property Favorito[] $favoritos
 * @property Requisicao[] $requisicaos
 * @property User $utilizador
 */
class Utilizador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilizador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['primeiro_nome', 'ultimo_nome', 'numero', 'dta_nascimento', 'nif', 'num_telemovel'], 'required'],
            [['bloqueado', 'num_telemovel'], 'integer'],
            [['dta_bloqueado', 'dta_nascimento', 'dta_registo'], 'safe'],
            [['primeiro_nome', 'ultimo_nome', 'foto_perfil'], 'string', 'max' => 50],
            [['numero'], 'string', 'max' => 4],
            [['nif'], 'string', 'max' => 9],
            [['id_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_utilizador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_utilizador' => 'Id Utilizador',
            'primeiro_nome' => 'Primeiro Nome',
            'ultimo_nome' => 'Ultimo Nome',
            'numero' => 'Numero',
            'bloqueado' => 'Bloqueado',
            'dta_bloqueado' => 'Dta Bloqueado',
            'dta_nascimento' => 'Dta Nascimento',
            'nif' => 'Nif',
            'num_telemovel' => 'Num Telemovel',
            'dta_registo' => 'Dta Registo',
            'foto_perfil' => 'Foto Perfil',
        ];
    }


    public function atribuirRoleLeitor()
    {
        $auth = \Yii::$app->authManager;
        $leitorRole = $auth->getRole('leitor');
        $auth->assign($leitorRole, $this->getId());
    }


    public function gerarNumeroLeitor()
    {
        $subQuery = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'leitor']);
        $ultimoLeitor = Utilizador::find()->where(['id_utilizador' => $subQuery])->orderBy(['id_utilizador'=> SORT_DESC])->one();

        if($ultimoLeitor == null){
            return "a000";
        }

        $letra = substr($ultimoLeitor->numero,0,1);
        $numero = substr($ultimoLeitor->numero,1,3);


        if ($numero == 999) {
            $proximaLetra = $this->proximoAsciiLetra($letra);
            if($proximaLetra == null){
                return null;
            }
            $numero = "000";
            return $proximaLetra . $numero;

        }else{
            $proximoNumero = $numero + 1;
            $proximoNumero = $this->colocarZeros($proximoNumero);
            return $letra . $proximoNumero;
        }
    }

    public function proximoAsciiLetra($letra)
    {
        $letraAscii = ord($letra);
        if($letraAscii != 122){
            $proximaletraAscii = $letraAscii + 1;
            return chr($proximaletraAscii);
        }else{
            return null;
        }
    }

    public function colocarZeros($proximoNumero){
        if (strlen($proximoNumero) < 2) {
            $proximoNumero = 0 . $proximoNumero;
        }
        if (strlen($proximoNumero) < 3) {
            $proximoNumero = 0 . $proximoNumero;
        }

        return $proximoNumero;
    }


    /**
     * Gets query for [[Administrador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdministrador()
    {
        return $this->hasOne(Administrador::className(), ['id_admin' => 'id_utilizador']);
    }

    /**
     * Gets query for [[Avaliacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::className(), ['id_utilizador' => 'id_utilizador']);
    }

    /**
     * Gets query for [[Bibliotecario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBibliotecario()
    {
        return $this->hasOne(Bibliotecario::className(), ['id_bibliotecario' => 'id_utilizador']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['id_utilizador' => 'id_utilizador']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::className(), ['id_utilizador' => 'id_utilizador']);
    }

    /**
     * Gets query for [[Requisicaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaos()
    {
        return $this->hasMany(Requisicao::className(), ['id_utilizador' => 'id_utilizador']);
    }


    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::className(), ['id' => 'id_utilizador']);
    }

}
