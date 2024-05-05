<?php

namespace multebox\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use multebox\models\Chart as ChartModel;

/**
 * BannerData represents the model behind the search form about `\multebox\models\BannerData`.
 */
class Chart extends ChartModel
{
    public function rules()
    {
        return [
            [['id', 'added_by_id', 'updated_at'], 'integer'],
            [['chart_title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Chart::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'added_at' => $this->added_at,
            'updated_at' => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['like', 'chart_file', $this->chart_file])
            ->andFilterWhere(['like', 'chart_title', $this->chart_title]);


        return $dataProvider;
    }
}
