<?php

namespace app\models;

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
 * @property int $id_editora
 * @property int $id_biblioteca
 * @property int $id_autor
 *
 * @property Editora $editora
 * @property Biblioteca $biblioteca
 * @property Autor $autor
 * @property RequisicaoLivro[] $requisicaoLivros
 * @property Requisicao[] $requisicaos
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
            [['id_livro', 'titulo', 'isbn', 'ano', 'paginas', 'genero', 'idioma', 'formato', 'capa', 'id_editora', 'id_biblioteca', 'id_autor'], 'required'],
            [['id_livro', 'paginas', 'id_editora', 'id_biblioteca', 'id_autor'], 'integer'],
            [['ano'], 'safe'],
            [['titulo'], 'string', 'max' => 50],
            [['isbn'], 'string', 'max' => 13],
            [['genero'], 'string', 'max' => 80],
            [['idioma', 'formato'], 'string', 'max' => 15],
            [['capa'], 'string', 'max' => 1],
            [['id_livro'], 'unique'],
            [['id_editora'], 'exist', 'skipOnError' => true, 'targetClass' => Editora::className(), 'targetAttribute' => ['id_editora' => 'id_editora']],
            [['id_biblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::className(), 'targetAttribute' => ['id_biblioteca' => 'id_biblioteca']],
            [['id_autor'], 'exist', 'skipOnError' => true, 'targetClass' => Autor::className(), 'targetAttribute' => ['id_autor' => 'id_autor']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_livro' => 'Id Livro',
            'titulo' => 'Titulo',
            'isbn' => 'Isbn',
            'ano' => 'Ano',
            'paginas' => 'Paginas',
            'genero' => 'Genero',
            'idioma' => 'Idioma',
            'formato' => 'Formato',
            'capa' => 'Capa',
            'id_editora' => 'Id Editora',
            'id_biblioteca' => 'Id Biblioteca',
            'id_autor' => 'Id Autor',
        ];
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
     * Gets query for [[Biblioteca]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBiblioteca()
    {
        return $this->hasOne(Biblioteca::className(), ['id_biblioteca' => 'id_biblioteca']);
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
     * Gets query for [[RequisicaoLivros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaoLivros()
    {
        return $this->hasMany(RequisicaoLivro::className(), ['id_livro' => 'id_livro']);
    }

    /**
     * Gets query for [[Requisicaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaos()
    {
        return $this->hasMany(Requisicao::className(), ['id_requisicao' => 'id_requisicao'])->viaTable('requisicao_livro', ['id_livro' => 'id_livro']);
    }
}
