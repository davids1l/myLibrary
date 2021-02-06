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
            [['id_transporte', 'id_bib_despacho', 'id_bib_recetora', 'id_requisicao'], 'integer'],
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
            'id_requisicao' => $this->id_requisicao,
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

        if($type == 1) {
            $type = "A aguardar tratamento";
        } else if($type == 2) {
            $type = "Em transporte";
        } else if($type == 3) {
            $type = "Concluído";
        }

        //obter o id da biblioteca do funcionario
        $id_bib_bibliotecario = Utilizador::find()
            ->select('id_biblioteca')
            ->where(['id_utilizador' => Yii::$app->user]);

        //encontrar os transportes a tratar
        $query = Transporte::find()
            ->where(['estado' => $type])
            ->andWhere(['id_biblioteca_despacho' => $id_bib_bibliotecario])
            ->orderBy(['id_transporte' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5],
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
            //'id_bib_levantamento' => $this->id_bib_levantamento,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
