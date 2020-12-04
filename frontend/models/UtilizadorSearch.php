<?php

namespace app\models;

use frontend\models\Utilizador;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UtilizadorSearch represents the model behind the search form of `app\models\Utilizador`.
 */
class UtilizadorSearch extends Utilizador
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_utilizador'], 'integer'],
            [['primeiro_nome', 'ultimo_nome', 'dta_nacimento', 'nif', 'email', 'dta_registo', 'foto_perfil', 'password'], 'safe'],
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
        $query = Utilizador::find();

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
            'id_utilizador' => $this->id_utilizador,
            'dta_nacimento' => $this->dta_nacimento,
            'dta_registo' => $this->dta_registo,
        ]);

        $query->andFilterWhere(['like', 'primeiro_nome', $this->primeiro_nome])
            ->andFilterWhere(['like', 'ultimo_nome', $this->ultimo_nome])
            ->andFilterWhere(['like', 'nif', $this->nif])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'foto_perfil', $this->foto_perfil])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
