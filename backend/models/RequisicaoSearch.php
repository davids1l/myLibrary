<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Requisicao;
use yii\db\Query;

/**
 * RequisicaoSearch represents the model behind the search form of `app\models\Requisicao`.
 */
class RequisicaoSearch extends Requisicao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_requisicao', 'id_utilizador', 'id_bib_levantamento'], 'integer'],
            [['dta_levantamento', 'dta_entrega', 'estado'], 'safe'],
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
        $query = Requisicao::find();

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
            'id_requisicao' => $this->id_requisicao,
            'dta_levantamento' => $this->dta_levantamento,
            'dta_entrega' => $this->dta_entrega,
            'id_utilizador' => $this->id_utilizador,
            'id_bib_levantamento' => $this->id_bib_levantamento,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }

    public function searchFiltered($params, $type)
    {
        /*
         *  $subQueryRole = (new Query())->select('user_id')->from('auth_assignment')->where(['item_name' => 'bibliotecario']);
         *  $query = Utilizador::find()->where(['id_utilizador' => $subQueryRole])->orderBy('id_utilizador');
         * */

        if($type == 1)
            $type = "A aguardar tratamento";
        else if($type == 2)
            $type = "Pronta a levantar";

        $query = Requisicao::find()->where(['estado' => $type])->orderBy('id_requisicao');

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
            'id_requisicao' => $this->id_requisicao,
            'dta_levantamento' => $this->dta_levantamento,
            'dta_entrega' => $this->dta_entrega,
            'id_utilizador' => $this->id_utilizador,
            'id_bib_levantamento' => $this->id_bib_levantamento,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
