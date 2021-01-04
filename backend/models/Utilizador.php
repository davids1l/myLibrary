<?php

namespace app\models;

use common\models\User;
use Yii;


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
 * @property string $num_telemovel
 * @property string $dta_registo
 * @property string|null $foto_perfil
 * @property int|null $id_biblioteca
 *
 * @property Avaliacao[] $avaliacaos
 * @property Comentario[] $comentarios
 * @property Favorito[] $favoritos
 * @property Requisicao[] $requisicaos
 * @property Biblioteca $biblioteca
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
            [['bloqueado', 'id_biblioteca', 'num_telemovel'], 'integer'],
            [['dta_bloqueado', 'dta_nascimento', 'dta_registo'], 'safe'],
            [['primeiro_nome', 'ultimo_nome', 'foto_perfil'], 'string', 'max' => 50],
            [['numero'], 'string', 'max' => 4],
            [['id_biblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::className(), 'targetAttribute' => ['id_biblioteca' => 'id_biblioteca']],
            [['id_utilizador'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_utilizador' => 'id']],

            ['nif', 'required'],
            ['nif', 'integer'],
            ['nif', 'unique', 'targetClass' => '\app\models\Utilizador', 'message' => 'Este NIF já se encontra em utilização'],
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
            'id_biblioteca' => 'Id Biblioteca',
        ];
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
     * Gets query for [[Biblioteca]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioteca()
    {
        return $this->hasOne(Biblioteca::className(), ['id_biblioteca' => 'id_biblioteca']);
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @param int $id_user
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_utilizador']);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
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
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }
}
