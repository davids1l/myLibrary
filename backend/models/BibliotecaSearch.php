<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Models\Biblioteca;

/**
 * BibliotecaSearch represents the model behind the search form of `app\Models\Biblioteca`.
 */
class BibliotecaSearch extends Biblioteca
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_biblioteca'], 'integer'],
            [['nome', 'cod_postal'], 'safe'],
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
        $query = Biblioteca::find();

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
            'id_biblioteca' => $this->id_biblioteca,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'cod_postal', $this->cod_postal]);

        return $dataProvider;
    }
}
