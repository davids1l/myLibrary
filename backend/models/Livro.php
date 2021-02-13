<?php

namespace app\models;

use Bluerhinos\phpMQTT;
use Yii;

/**
 * This is the model class for table "livro".
 *
 * @property int $id_livro
 * @property string $titulo
 * @property string $isbn
 * @property string $ano
 * @property int $paginas
 * @property string $genero
 * @property string $idioma
 * @property string $formato
 * @property string $capa
 * @property string $sinopse
 * @property int $id_editora
 * @property int $id_biblioteca
 * @property int $id_autor
 *
 * @property Avaliacao[] $avaliacaos
 * @property Comentario[] $comentarios
 * @property Favorito[] $favoritos
 * @property Autor $autor
 * @property Biblioteca $biblioteca
 * @property Editora $editora
 * @property Requisicao[] $requisicaos
 * @property RequisicaoLivro[] $requisicaoLivros
 * @property Requisicao[] $requisicaos0
 */
class Livro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'livro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'isbn', 'ano', 'paginas', 'genero', 'idioma', 'formato', 'capa', 'sinopse', 'id_editora', 'id_biblioteca', 'id_autor'], 'required'],
            [['ano'], 'safe'],
            [['paginas', 'id_editora', 'id_biblioteca', 'id_autor'], 'integer'],
            [['sinopse'], 'string'],
            [['titulo'], 'string', 'max' => 50],
            [['isbn'], 'integer'],
            [['genero'], 'string', 'max' => 80],
            [['idioma', 'formato'], 'string', 'max' => 15],
            [['capa'], 'string', 'max' => 255],
            [['id_autor'], 'exist', 'skipOnError' => true, 'targetClass' => Autor::className(), 'targetAttribute' => ['id_autor' => 'id_autor']],
            [['id_biblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::className(), 'targetAttribute' => ['id_biblioteca' => 'id_biblioteca']],
            [['id_editora'], 'exist', 'skipOnError' => true, 'targetClass' => Editora::className(), 'targetAttribute' => ['id_editora' => 'id_editora']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_livro' => 'Id Livros',
            'titulo' => 'Titulo',
            'isbn' => 'Isbn',
            'ano' => 'Ano',
            'paginas' => 'Paginas',
            'genero' => 'Genero',
            'idioma' => 'Idioma',
            'formato' => 'Formato',
            'capa' => 'Capa',
            'sinopse' => 'Sinopse',
            'id_editora' => 'Id Editora',
            'id_biblioteca' => 'Id Biblioteca',
            'id_autor' => 'Id Autor',
        ];
    }

    /*public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $id_livro=$this->id_livro;
        $titulo=$this->titulo;
        $isbn=$this->isbn;
        $ano=$this->ano;
        $paginas=$this->paginas;
        $genero=$this->genero;
        $idioma=$this->idioma;
        $formato=$this->formato;
        $capa=$this->capa;
        $sinopse=$this->sinopse;
        $id_editora=$this->id_editora;
        $id_biblioteca=$this->id_biblioteca;
        $id_autor=$this->id_autor;

        $myObj = new \stdClass();
        $myObj->id_livro = $id_livro;
        $myObj->titulo = $titulo;
        $myObj->isbn = $isbn;
        $myObj->ano = $ano;
        $myObj->paginas = $paginas;
        $myObj->genero = $genero;
        $myObj->idioma = $idioma;
        $myObj->formato = $formato;
        $myObj->capa = $capa;
        $myObj->sinopse = $sinopse;
        $myObj->id_editora = $id_editora;
        $myObj->id_biblioteca = $id_biblioteca;
        $myObj->id_autor = $id_autor;

        $myJson = json_encode($myObj);

        if($insert){
            $this->FazPublish('livro/novo', $myJson);
        }else{
            $this->FazPublish('livro/update', $myJson);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id_livro = $this->id_livro;

        $myObj = new \stdClass();
        $myObj->id_livro = $id_livro;

        $myJSON = json_encode($myObj);

        $this->FazPublish("livro/delete", $myJSON);
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
    }*/

    /**
     * Gets query for [[Avaliacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::className(), ['id_livro' => 'id_livro']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['id_livro' => 'id_livro']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::className(), ['id_livro' => 'id_livro']);
    }

    /**
     * Gets query for [[Autor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(Autor::className(), ['id_autor' => 'id_autor']);
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
     * Gets query for [[Editora]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEditora()
    {
        return $this->hasOne(Editora::className(), ['id_editora' => 'id_editora']);
    }

    /**
     * Gets query for [[Requisicaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaos()
    {
        return $this->hasMany(Requisicao::className(), ['id_livro' => 'id_livro']);
    }

    /**
     * Gets query for [[RequisicaoLivros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaoLivros()
    {
        return $this->hasMany(RequisicaoLivro::className(), ['id_livro' => 'id_livro']);
    }

    /**
     * Gets query for [[Requisicaos0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaos0()
    {
        return $this->hasMany(Requisicao::className(), ['id_requisicao' => 'id_requisicao'])->viaTable('requisicao_livro', ['id_livro' => 'id_livro']);
    }
}
