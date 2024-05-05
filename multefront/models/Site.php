<?php

namespace multefront\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "tbl_city".
 *
 * @property integer $id
 * @property string $city
 * @property integer $active
 * @property integer $state_id
 * @property integer $country_id
 * @property integer $added_at
 * @property integer $updated_at
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//           [['full_name','product_or_service_link', 'week','email','price'], 'required'],
//            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'price' => Yii::t('app', 'Price'),
            'product_or_service_link' => Yii::t('app', 'Product or Service Link'),
            'week' => Yii::t('app', 'Week'),

        ];
    }


}
