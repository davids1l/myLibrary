<?php

namespace app\models;

use Carbon\Carbon;
use Yii;
use yii\base\Exception;
use yii\rbac\Role;
use yii\web\IdentityInterface;
use function GuzzleHttp\Psr7\str;

/**
 * This is the model class for table "utilizador".
 *
 * @property int $id_utilizador
 * @property string $primeiro_nome
 * @property string $ultimo_nome
 * @property string $dta_nascimento
 * @property string $nif
 * @property string $email
 * @property int $num_telemovel
 * @property string $dta_registo
 * @property string $foto_perfil
 * @property string $password
 *
 * @property Administrador $administrador
 * @property Avaliacao[] $avaliacaos
 * @property Bibliotecario $bibliotecario
 * @property Comentario[] $comentarios
 * @property Favorito[] $favoritos
 * @property Leitor $leitor
 * @property Requisicao[] $requisicaos
 */
class Utilizador extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['primeiro_nome', 'ultimo_nome', 'dta_nascimento', 'nif', 'email', 'num_telemovel', 'password'], 'required'],
            [['dta_nascimento', 'dta_registo'], 'safe'],
            [['num_telemovel'], 'integer'],
            [['primeiro_nome', 'ultimo_nome', 'foto_perfil', 'password'], 'string', 'max' => 250],
            [['nif'], 'string', 'max' => 9],
            [['email'], 'string', 'max' => 80],
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
            'dta_nascimento' => 'Dta Nascimento',
            'nif' => 'Nif',
            'email' => 'Email',
            'num_telemovel' => 'Num Telemovel',
            'dta_registo' => 'Dta Registo',
            'foto_perfil' => 'Foto Perfil',
            'password' => 'Password',
        ];
    }

    public function validarPassword($password){
        $password = $this->encriptarPassword($password);
        $result = Yii::$app->security->validatePassword($password, $this->password);
        echo var_dump($result, $password, $this->password);
        die();
        return $result;
    }

    public function signup(){

        if (!$this->validate()) {
            return null;
        }

        $utilizador = new Utilizador();
        $utilizador->primeiro_nome = $this->primeiro_nome;
        $utilizador->ultimo_nome = $this->ultimo_nome;
        $utilizador->dta_nascimento = $this->dta_nascimento;
        $utilizador->nif = $this->nif;
        $utilizador->email = $this->email;
        $utilizador->num_telemovel = $this->num_telemovel;

        if(strlen($this->password) < 8 ){
            Yii::$app->session->setFlash('error', 'Palavra-passe inválida. Introduza uma com 8 ou mais caracteres.');
            return null;
        }


        //Encripta a password
        $utilizador->password = $this->encriptarPassword($utilizador->password);


        //Procura na BD se existe algum utilizador com o mesmo email
        $email = Utilizador::find()->where(['email' => $utilizador->email])->one();
        if($email != ''){
            Yii::$app->session->setFlash('error', 'O email introduzido já está em uso.');
            return null;
        }

        if($utilizador->dta_nascimento > Carbon::now()){
            Yii::$app->session->setFlash('error', 'Data de nascimento inválida.');
            return null;
        }

        //Procura na BD se existe algum utilizador com o mesmo NIF
        $nif = Utilizador::find()->where(['nif' => $utilizador->nif])->one();
        if($nif != ''){
            Yii::$app->session->setFlash('error', 'O NIF introduzido já está em uso.');
            return null;
        }

        //Descobrir o primeiro caracter do número de telemóvel
        $numTelemovel = $utilizador->num_telemovel;
        $primeiroCharTelemovel = $numTelemovel[0];


        if($primeiroCharTelemovel != 9 || strlen($utilizador->num_telemovel) != 9){
            Yii::$app->session->setFlash('error', 'Insira um número de telemóvel válido.');
            return null;
        }

        $utilizador->save();
        $utilizador->atribuirRoleLeitor();

        //$user->generateAuthKey();
        //$user->generateEmailVerificationToken();

        return true /*&& $this->sendEmail($user)*/;
    }

    public function encriptarPassword($password){
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }


    public function atribuirRoleLeitor(){
        $auth = \Yii::$app->authManager;
        $leitorRole = $auth->getRole('leitor');
        $auth->assign($leitorRole, $this->getId());
    }


    public function gerarNumLeitor(){
        $numeroGerado = rand(0,999);
        if(strlen($numeroGerado) < 2){
            $numeroGerado = '0' . $numeroGerado;
        }
        if(strlen($numeroGerado) < 3){
            $numeroGerado = '0' . $numeroGerado;
        }
        $numLeitor = "a" . $numeroGerado;
        echo var_dump($numLeitor);
        die();
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
     * Gets query for [[Leitor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeitor()
    {
        return $this->hasOne(Leitor::className(), ['id_leitor' => 'id_utilizador']);
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
    public static function findIdentity($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
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
}
