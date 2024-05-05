<?php

namespace multebox\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use multebox\models\Paidads as PaidadsModel;



/**
 * User represents the model behind the search form about `\multebox\models\User`.
 */
class Paidads extends PaidadsModel
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['full_name','email','price','product_or_service_link','week'], 'safe'],
        ];
    }
    public function search($params)
    {
        $query = PaidadsModel::find()->orderBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        if (!($this->load($params) && $this->validate())) {
//            return $dataProvider;
//        }
//        echo '<pre>';
////        print_r($dataProvider);
////        die;

        $query->andFilterWhere([
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'price' => $this->price,
            'product_or_service_link' => $this->product_or_service_link,
            'week' => $this->week,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'product_or_service_link', $this->product_or_service_link])
            ->andFilterWhere(['like', 'week', $this->week]);

        return $dataProvider;
    }

	
}
