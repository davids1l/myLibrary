<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilizador".
 *
 * @property int $id_utilizador
 * @property string $primeiro_nome
 * @property string $ultimo_nome
 * @property string $dta_nacimento
 * @property string $nif
 * @property string $email
 * @property string $dta_registo
 * @property resource|null $foto_perfil
 * @property string $password
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
            [['primeiro_nome', 'ultimo_nome', 'dta_nacimento', 'nif', 'email', 'password'], 'required'],
            [['dta_nacimento', 'dta_registo'], 'safe'],
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
            'dta_nacimento' => 'Dta Nacimento',
            'nif' => 'Nif',
            'email' => 'Email',
            'dta_registo' => 'Dta Registo',
            'foto_perfil' => 'Foto Perfil',
            'password' => 'Password',
        ];
    }
}
