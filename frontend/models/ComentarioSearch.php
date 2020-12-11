<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comentario;

/**
 * ComentarioSearch represents the model behind the search form of `app\models\Comentario`.
 */
class ComentarioSearch extends Comentario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_comentario', 'id_livro', 'id_utilizador'], 'integer'],
            [['dta_comentario', 'comentario'], 'safe'],
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
        $query = Comentario::find();
        //$query->joinWith(['utilizador']);

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
            //'id_comentario' => $this->id_comentario,
            //'dta_comentario' => $this->dta_comentario,
            //'id_livro' => $this->id_livro,
            'id_utilizador' => $this->id_utilizador,
        ]);

        $query->andFilterWhere(['like', 'comentario', $this->comentario]);
            //->andFilterWhere(['like', 'utilizador.id_utilizador', $this->id_utilizador]);

        return $dataProvider;
    }
}
