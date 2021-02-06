<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transporte;

/**
 * TransporteSearch represents the model behind the search form of `app\models\Transporte`.
 */
class TransporteSearch extends Transporte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transporte', 'id_bib_despacho', 'id_bib_recetora'], 'integer'],
            [['estado', 'dta_despacho', 'dta_recebida'], 'safe'],
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
        $query = Transporte::find();

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
            'id_transporte' => $this->id_transporte,
            'id_bib_despacho' => $this->id_bib_despacho,
            'id_bib_recetora' => $this->id_bib_recetora,
            'dta_despacho' => $this->dta_despacho,
            'dta_recebida' => $this->dta_recebida,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
