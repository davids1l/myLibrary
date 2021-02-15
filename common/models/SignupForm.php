<?php

namespace common\models;

use app\models\Utilizador;
use Carbon\Carbon;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    //public $username;
    public $email;
    public $password;
    public $primeiro_nome;
    public $ultimo_nome;
    public $dta_nascimento;
    public $nif;
    public $num_telemovel;
    public $confirmarPassword;
    public $id_biblioteca;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //['username', 'trim'],
            //['username', 'required'],
            //['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            //['username', 'string', 'min' => 2, 'max' => 255],

            [['email', 'password', 'primeiro_nome', 'ultimo_nome', 'nif', 'num_telemovel', 'confirmarPassword', 'dta_nascimento'], 'required', 'message' => '{attribute} não pode estar em branco'],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já se encontra em utilização.'],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],


            [['nif', 'num_telemovel'], 'string', 'min' => 9, 'max' => 9, 'tooShort' => '{attribute} tem de conter 9 dígitos', 'tooLong' => '{attribute} tem de conter 9 dígitos'],

            ['nif', 'unique', 'targetClass' => '\frontend\models\Utilizador', 'message' => 'Este NIF já se encontra em utilização'],



        ];
    }

    public function attributeLabels()
    {
        return [
            'id_utilizador' => 'Id Utilizador',
            'primeiro_nome' => 'Nome',
            'ultimo_nome' => 'Apelido',
            'numero' => 'Numero',
            'bloqueado' => 'Bloqueado',
            'dta_bloqueado' => 'Dta Bloqueado',
            'dta_nascimento' => 'Data de nascimento',
            'nif' => 'NIF',
            'num_telemovel' => 'Número de Telemóvel',
            'dta_registo' => 'Dta Registo',
            'foto_perfil' => 'Foto Perfil',
            'email' => 'Endereço de email',
            'password' => 'Palavra-passe',
            'confirmarPassword' => 'Confirmação da palavra-passe'

        ];
    }

    /**
     * Signs user up.
     *
     * @param $tipo int se for 0 é leitor, 1 é bibliotecario e 2 é admin
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup($tipo)
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $utilizador = new \frontend\models\Utilizador();


        //Remove os acentos do primeiro e ultimo nome
        $primeiro_nome = preg_replace('/[^a-z]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", $this->primeiro_nome));
        $ultimo_nome = preg_replace('/[^a-z]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", $this->ultimo_nome));


        $user->username = strtolower($primeiro_nome) . strtolower($ultimo_nome);
        $user->email = $this->email;

        //Verifica se a password e a confirmação da password são iguais
        if($this->password != $this->confirmarPassword){
            $this->addError('confirmarPassword', 'Confirmação da Palavra-Passe incorreta');
            return null;
        }
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = 10;

        $utilizador->primeiro_nome = $this->primeiro_nome;
        $utilizador->ultimo_nome = $this->ultimo_nome;
        $utilizador->dta_nascimento = $this->dta_nascimento;
        $utilizador->foto_perfil = $utilizador->atribuirImg();
        $utilizador->id_biblioteca = $this->id_biblioteca;


        if($utilizador->validarDataNascimento() == false){
            $this->addError('dta_nascimento', 'Data de nascimento inválida');
            return null;
        }


        if(!is_numeric($this->nif)){
            $this->addError('nif', 'NIF inválido. NIF só pode conter números.');
            return null;
        }else{
            $utilizador->nif = $this->nif;
        }

        if(!is_numeric($this->num_telemovel)){
            $this->addError('num_telemovel', 'Nº de telemóvel inválido. Nº de telemóvel só pode conter números.');
            return null;
        }else{
            $utilizador->num_telemovel = $this->num_telemovel;
        }


        if($utilizador->validarNumTelemovel() == false){
            $this->addError('num_telemovel', 'Número de telemóvel inválido. Deve começar por 9');
            return null;
        }

        switch ($tipo){
            case 0:
                $utilizador->numero = $utilizador->gerarNumeroLeitor();
                if($utilizador->numero == null){
                    Yii::$app->session->setFlash('error', 'Impossível registar. O sistema excedeu o limite de leitores.');
                    return null;
                }

                $user->save();
                $utilizador->id_utilizador = $user->getId();
                $utilizador->save();
                $utilizador->atribuirRoleLeitor();
                break;

            case 1:
                $utilizador->numero = $utilizador->gerarNumeroBibliotecario();
                if($utilizador->numero == null){
                    Yii::$app->session->setFlash('error', 'Impossível registar. O sistema excedeu o limite de bibliotecários.');
                    return null;
                }

                $user->save();
                $utilizador->id_utilizador = $user->getId();
                $utilizador->save();
                $utilizador->atribuirRoleBibliotecario();
                break;
            case 2:

                break;
        }




        $user->username = $user->username . "_" .  $utilizador->numero;
        $user->save();


        return true;// && $this->sendEmail($user);
    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
