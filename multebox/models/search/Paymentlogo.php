<?php

namespace multebox\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use multebox\models\Paymentlogo as PaymentlogoModel;

/**
 * BannerData represents the model behind the search form about `\multebox\models\BannerData`.
 */
class Paymentlogo extends PaymentlogoModel
{
    public function rules()
    {
        return [
            [['id', 'added_by_id', 'updated_at'], 'integer'],
            [['paymentlogo_title'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Paymentlogo::find();

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
            ->andFilterWhere(['like', 'paymentlogo_title', $this->paymentlogo_title]);


        return $dataProvider;
    }
}
