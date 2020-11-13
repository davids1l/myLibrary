<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Editora;

/**
 * EditoraSearch represents the model behind the search form of `app\models\Editora`.
 */
class EditoraSearch extends Editora
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_editora', 'id_pais'], 'integer'],
            [['designacao'], 'safe'],
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
        $query = Editora::find();

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
            'id_editora' => $this->id_editora,
            'id_pais' => $this->id_pais,
        ]);

        $query->andFilterWhere(['like', 'designacao', $this->designacao]);

        return $dataProvider;
    }
}
