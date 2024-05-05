<?php

namespace multebox\models;

use Yii;
use multebox\models\search\MulteModel;

/**
 * This is the model class for table "{{%tbl_banner_data}}".
 *
 * @property int $id
 * @property string $banner_name
 * @property string $text_1
 * @property string $text_2
 * @property string $text_3
 * @property int $category_id
 * @property int $sub_category_id
 * @property int $sub_sub_category_id
 * @property int $product_id
 * @property int $added_at
 * @property int $updated_at
 */
class Paymentlogo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_paymentlogo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'added_by_id'], 'required'],
            [['paymentlogo_title'], 'string', 'max' => 255],
            [['active'], 'integer'],
			[['paymentlogo_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'checkExtensionByMimeType'=>false],
			[['paymentlogo_file'], 'required', 'on'=> 'create']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'paymentlogo_file' => Yii::t('app', 'Payment Logo File'),
            'paymentlogo_title' => Yii::t('app', 'Payment Logo Title'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

	public function upload($name)
    {
        if ($this->validate()) {
			//$this->banner_file->saveAs(Yii::getAlias('@multefront').'/web/images/upload/' . $name);
			MulteModel::saveFileToServer($this->paymentlogo_file->tempName, $name, Yii::$app->params['web_folder']."/paymentlogo_file");
            return true;
        } else {
			Yii::$app->session->setFlash('error', $this->errors['paymentlogo_file'][0]);
            return false;
        }
    }

	public function getProduct()
    {
    	return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
