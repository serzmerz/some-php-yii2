<?php

namespace common\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Companies;

/**
 * CompaniesSearch represents the model behind the search form about `common\models\Companies`.
 */
class CompaniesSearch extends Companies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_stage', 'revenue', 'raising', 'user_id', 'status'], 'integer'],
            [['name', 'address', 'img_url', 'description', 'address_1', 'address_2', 'tel_1', 'tel_2', 'fax', 'website', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Companies::find();

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
            'id' => $this->id,
            'product_stage' => $this->product_stage,
            'revenue' => $this->revenue,
            'raising' => $this->raising,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'img_url', $this->img_url])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address_1', $this->address_1])
            ->andFilterWhere(['like', 'address_2', $this->address_2])
            ->andFilterWhere(['like', 'tel_1', $this->tel_1])
            ->andFilterWhere(['like', 'tel_2', $this->tel_2])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'website', $this->website]);

        return $dataProvider;
    }
}
