<?php

namespace multebox\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use multebox\models\Title as TitleModel;

/**
 * ProductCategory represents the model behind the search form about `multebox\models\ProductCategory`.
 */
class Title extends TitleModel
{
    public function rules()
    {
        return [
            [['id', 'active', 'added_at', 'updated_at'], 'integer'],
            [['title_name'], 'safe'],
            [['title_name', 'active'], 'string', 'max' => 255],
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
		$query = Title::find()->orderBy('title_name');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'title_name' => $this->title_name,
            'added_at' => $this->added_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title_name', $this->title_name]);

        return $dataProvider;
    }
}
