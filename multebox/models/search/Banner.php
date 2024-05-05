<?php

namespace multebox\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use multebox\models\Banner as BannerModel;

/**
 * BannerData represents the model behind the search form about `\multebox\models\BannerData`.
 */
class Banner extends BannerModel
{
    public function rules()
    {
        return [
            [['id', 'added_by_id', 'updated_at'], 'integer'],
            [[ 'banner_new_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Banner::find();

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
			->andFilterWhere(['like', 'banner_new_name', $this->banner_new_name])
           ;

        return $dataProvider;
    }
}
