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
            Yii::$app->session->setFlash('error', 'Confirmação da Palavra-Passe incorreta.');
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
            Yii::$app->session->setFlash('error', 'Data de nascimento inválida.');
            return null;
        }


        $utilizador->nif = $this->nif;
        $utilizador->num_telemovel = $this->num_telemovel;

        if($utilizador->validarNumTelemovel() == false){
            Yii::$app->session->setFlash('error', 'Número de telemóvel inválido. Insira um número que comece por 9.');
            return null;
        }

        switch ($tipo){
            case 0:
                $utilizador->numero = $utilizador->gerarNumeroLeitor();
                if($utilizador->numero == null){
                    Yii::$app->session->setFlash('error', 'Impossível registar. O sistema excedeu o limite de utilizadores.');
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
