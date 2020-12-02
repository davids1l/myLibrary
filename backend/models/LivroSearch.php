<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Livro;

/**
 * LivroSearch represents the model behind the search form of `app\models\Livro`.
 */
class LivroSearch extends Livro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_livro', 'paginas', 'id_editora', 'id_biblioteca', 'id_autor'], 'integer'],
            [['titulo', 'isbn', 'ano', 'genero', 'idioma', 'formato', 'capa', 'sinopse'], 'safe'],
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
            //'id_livro' => $this->id_livro,
            'titulo' => $this->titulo,
            /*'ano' => $this->ano,
            'paginas' => $this->paginas,
            'id_editora' => $this->id_editora,
            'id_biblioteca' => $this->id_biblioteca,
            'id_autor' => $this->id_autor,*/
        ]);

        $query->orFilterWhere(['like', 'titulo', $this->titulo])
            ->orFilterWhere(['like', 'isbn', $this->isbn])
            ->orFilterWhere(['like', 'genero', $this->genero])
            ->orFilterWhere(['like', 'idioma', $this->idioma])
            ->orFilterWhere(['like', 'formato', $this->formato])
            ->orFilterWhere(['like', 'capa', $this->capa])
            ->orFilterWhere(['like', 'sinopse', $this->sinopse]);

        return $dataProvider;
    }
}
