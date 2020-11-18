<?php

namespace app\models;

use Carbon\Carbon;
use frontend\controllers\SiteController;
use SebastianBergmann\CodeCoverage\Util;
use Symfony\Component\Yaml\Dumper;
use Yii;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "utilizador".
 *
 * @property int $id_utilizador
 * @property string $primeiro_nome
 * @property string $ultimo_nome
 * @property string $dta_nascimento
 * @property string $nif
 * @property string $email
 * @property string $dta_registo
 * @property resource|null $foto_perfil
 * @property string $password
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
            [['primeiro_nome', 'ultimo_nome', 'dta_nascimento', 'nif', 'email', 'password'], 'required'],
            [['dta_nascimento', 'dta_registo'], 'safe'],
            [['foto_perfil'], 'string'],
            [['primeiro_nome', 'ultimo_nome'], 'string', 'max' => 50],
            [['nif'], 'string', 'max' => 9],
            [['email'], 'string', 'max' => 80],
            [['password'], 'string', 'max' => 120],
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
            'dta_registo' => 'Dta Registo',
            'foto_perfil' => 'Foto Perfil',
            'password' => 'Password',
        ];
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
        $utilizador->dta_registo = Carbon::now();

        //Encripta a password
        $password = $this->password;
        $passwordHashed = md5($password);
        $utilizador->password = $passwordHashed;


        //Procura na BD se existe algum utilizador com o mesmo email
        $email = Utilizador::find()->where(['email' => $utilizador->email])->one();


        if($email != ''){

            //FALTA MENSAGEM DE AVISO A DIZER QUE O EMAIL INSERIDO JÁ FOI UTILIZADO

            return null;
        }

        //$user->generateAuthKey();
        //$user->generateEmailVerificationToken();

        return $utilizador->save() /*&& $this->sendEmail($user)*/;
    }


    public function login(){
        if ($this->validate()) {
            $utilizadorProcurado = $this::findIdentity($this->email);
            $passwordHashed = md5($utilizadorProcurado->password);
            $utilizadorProcurado->password = $passwordHashed;
            var_dump($utilizadorProcurado);

            //return Yii::$app->user->login($utilizadorProcurado)/*, $this->rememberMe ? 3600 * 24 * 30 : 0*/;
        }

        //return false;
    }


    /**
     * @inheritDoc
     */
    public static function findIdentity($email)
    {
        return static::findOne(['email' =>$email]);
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
        // TODO: Implement getId() method.
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
