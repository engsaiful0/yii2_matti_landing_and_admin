<?php

namespace multebox\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use multebox\models\Faq as FaqModel;

/**
 * ProductCategory represents the model behind the search form about `multebox\models\ProductCategory`.
 */
class Faq extends FaqModel
{
    public function rules()
    {
        return [
            [['id', 'active', 'added_at', 'updated_at'], 'integer'],
            [['faq_title','faq_details'], 'safe'],
            [['faq_title','faq_details', 'active'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
		/*if(Yii::$app->params['user_role'] == 'admin')
		{
			$query = ProductCategoryModel::find()->orderBy('name');
		}
		else
		{
			if(Yii::$app->user->identity->entity_type == 'vendor')
				$query = ProductCategoryModel::find()->where("added_by_id=".Yii::$app->user->identity->id)->orderBy('name');
			else
				$query = ProductCategoryModel::find()->where("id=0");
		}*/
		$query = Faq::find()->orderBy('faq_title');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'faq_title' => $this->faq_title,
            'faq_details' => $this->faq_details,
            'added_at' => $this->added_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'faq_title', $this->faq_title]);

        return $dataProvider;
    }
}
