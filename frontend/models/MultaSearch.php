<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Multa;

/**
 * MultaSearch represents the model behind the search form of `app\models\Multa`.
 */
class MultaSearch extends Multa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_multa'], 'integer'],
            [['data_multa', 'estado'], 'safe'],
            [['montante'], 'number'],
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
        $query = Multa::find();

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
            'id_multa' => $this->id_multa,
            'data_multa' => $this->data_multa,
            'montante' => $this->montante,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
