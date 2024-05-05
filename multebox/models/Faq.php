<?php

namespace multebox\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_product_category}}".
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property string $description
 * @property int $added_by_id
 * @property int $sort_order
 * @property int $added_at
 * @property int $updated_at
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_faq}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faq_title','faq_details', 'active'], 'required'],
            [['faq_title','faq_details'], 'string'],
            [['active'], 'integer'],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'faq_title' => Yii::t('app', 'Faq Title'),
            'faq_details' => Yii::t('app', 'Faq Details'),
            'active' => Yii::t('app', 'Active'),
            'added_by_id' => Yii::t('app', 'Added By ID'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
