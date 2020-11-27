<?php

namespace frontend\models;

use Carbon\Carbon;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\VarDumper;

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

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já se encontra em utilização.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['primeiro_nome', 'required'],

            ['ultimo_nome', 'required'],

            ['dta_nascimento', 'required'],

            ['nif', 'required'],
            ['nif', 'string', 'min' => 9, 'max' => 9],
            ['nif', 'unique', 'targetClass' => '\frontend\models\Utilizador', 'message' => 'Este NIF já se encontra em utilização'],

            ['num_telemovel', 'required'],
            ['num_telemovel', 'string', 'min' => 9, 'max' => 9],

            ['confirmarPassword', 'required'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $utilizador = new Utilizador();

        $user->username = strtolower($this->primeiro_nome) . strtolower($this->ultimo_nome);
        $user->email = $this->email;

        //Verifica se a password e a confirmação da password são iguais
        if($this->password != $this->confirmarPassword){
            Yii::$app->session->setFlash('error', 'Confirmação da Palavra-Passe incorreta.');
            return null;
        }
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();


        $utilizador->primeiro_nome = $this->primeiro_nome;
        $utilizador->ultimo_nome = $this->ultimo_nome;
        $utilizador->dta_nascimento = $this->dta_nascimento;

        //Verifica se a data de nascimento é válida
        if ($utilizador->dta_nascimento > Carbon::now()) {
            Yii::$app->session->setFlash('error', 'Data de nascimento inválida.');
            return null;
        }

        $utilizador->nif = $this->nif;
        $utilizador->num_telemovel = $this->num_telemovel;
        //Verifica se o primeiro caracter do número de telemóvel é um 9
        $numTelemovel = $utilizador->num_telemovel;
        $primeiroCharTelemovel = $numTelemovel[0];
        if ($primeiroCharTelemovel != 9) {
            Yii::$app->session->setFlash('error', 'Número de telemóvel inválido. Insira um número que comece por 9.');
            return null;
        }

        $utilizador->numero = $utilizador->gerarNumeroLeitor();
        if($utilizador->numero == null){
            Yii::$app->session->setFlash('error', 'Impossível registar. O sistema excedeu o limite de utilizadores.');
            return null;
        }


        $user->save();
        $utilizador->id_utilizador = $user->getId();
        $utilizador->save();
        $utilizador->atribuirRoleLeitor();

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
