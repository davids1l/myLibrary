<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leitor;

/**
 * LeitorSearch represents the model behind the search form of `app\models\Leitor`.
 */
class LeitorSearch extends Leitor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_leitor', 'bloqueado'], 'integer'],
            [['num_leitor', 'dta_bloqueado'], 'safe'],
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
        $query = Leitor::find();

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
            'id_leitor' => $this->id_leitor,
            'bloqueado' => $this->bloqueado,
            'dta_bloqueado' => $this->dta_bloqueado,
        ]);

        $query->andFilterWhere(['like', 'num_leitor', $this->num_leitor]);

        return $dataProvider;
    }
}
