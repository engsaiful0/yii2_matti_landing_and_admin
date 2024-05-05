<?php

namespace multebox\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use multebox\models\Logodetails as LogodetailsModel;

/**
 * BannerData represents the model behind the search form about `\multebox\models\BannerData`.
 */
class Logodetails extends LogodetailsModel
{
    public function rules()
    {
        return [
            [['id', 'added_by_id', 'updated_at'], 'integer'],
            [['logo_title','left_comment','right_comment'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LogodetailsModel::find();

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

        $query->andFilterWhere(['like', 'logo_title', $this->logo_title])
            ->andFilterWhere(['like', 'left_comment', $this->left_comment])
            ->andFilterWhere(['like', 'right_comment', $this->right_comment])
			;

        return $dataProvider;
    }
}
