<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Favorito;

/**
 * FavoritoSearch represents the model behind the search form of `app\models\Favorito`.
 */
class FavoritoSearch extends Favorito
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_favorito', 'id_livro', 'id_utilizador'], 'integer'],
            [['data_fav'], 'safe'],
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
        $query = Favorito::find();

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
            'id_favorito' => $this->id_favorito,
            'data_fav' => $this->data_fav,
            'id_livro' => $this->id_livro,
            'id_utilizador' => $this->id_utilizador,
        ]);

        return $dataProvider;
    }
}
