<?php

namespace common\models;

use app\models\Utilizador;
use Yii;
use yii\base\Model;


class FormularioLogin extends Model
{

    public $email;
    public $password;

    private $_utilizador;

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
            [['email', 'password'], 'required'],
            [['password'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 80],
            ['password', 'validarPassword'],
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

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUtilizador())/*, $this->rememberMe ? 3600 * 24 * 30 : 0*/ ;
        }

        return false;
    }

    public function validarPassword()
    {
        if (!$this->hasErrors()) {
            $utilizador = $this->getUtilizador();
            if (!$utilizador || !$utilizador->validarPassword($this->password)) {

                //$this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function getUtilizador(){
        if ($this->_utilizador === null) {
            $this->_utilizador = Utilizador::findIdentity($this->email);
        }
        return $this->_utilizador;
    }
}