<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Avaliacao;

/**
 * AvaliacaoSearch represents the model behind the search form of `app\models\Avaliacao`.
 */
class AvaliacaoSearch extends Avaliacao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_avaliacao', 'avaliacao', 'id_livro', 'id_utilizador'], 'integer'],
            [['data_avaliacao'], 'safe'],
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
        $query = Avaliacao::find();

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
            'id_avaliacao' => $this->id_avaliacao,
            'data_avaliacao' => $this->data_avaliacao,
            'avaliacao' => $this->avaliacao,
            'id_livro' => $this->id_livro,
            'id_utilizador' => $this->id_utilizador,
        ]);

        return $dataProvider;
    }
}
