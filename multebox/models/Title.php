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
class Title extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_title}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_name', 'active', 'added_by_id'], 'required'],
            [['title_name'], 'string', 'max' => 255],
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
            'title_name' => Yii::t('app', 'Title Name'),
            'active' => Yii::t('app', 'Active'),

            'added_by_id' => Yii::t('app', 'Added By ID'),

            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
