<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Livro;
use yii\db\Query;

/**
 * LivroSearch represents the model behind the search form of `app\models\Livros`.
 */
class LivroSearch extends Livro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_livro', 'ano', 'paginas', 'id_editora', 'id_biblioteca', 'id_autor'], 'integer'],
            [['titulo', 'isbn', 'genero', 'idioma', 'formato', 'capa', 'sinopse'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function procurar($params)
    {
        $titulo = $params['Livro']['titulo'];

        $query = Livro::find()
            ->where(['like', 'titulo',  $titulo])
            ->all();

        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Livro::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
           'id_livro' => $this->id_livro,
            'ano' => $this->ano,
            'paginas' => $this->paginas,
            'id_editora' => $this->id_editora,
            'id_biblioteca' => $this->id_biblioteca,
            'id_autor' => $this->id_autor,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'genero', $this->genero])
            ->andFilterWhere(['like', 'idioma', $this->idioma])
            ->andFilterWhere(['like', 'formato', $this->formato])
            ->andFilterWhere(['like', 'capa', $this->capa])
            ->andFilterWhere(['like', 'sinopse', $this->sinopse]);

        return $dataProvider;
    }
}
