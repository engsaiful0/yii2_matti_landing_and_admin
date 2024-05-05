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
class Chart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_chart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'added_by_id'], 'required'],
            [['chart_title'], 'string', 'max' => 255],
            [['active'], 'integer'],
//			[['chart_file','chart_file_ref_image1','chart_file_ref_image2','chart_file_ref_image3'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'checkExtensionByMimeType'=>false],
//            [['chart_file_ref_image2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'checkExtensionByMimeType'=>false],
//            [['chart_file_ref_image1'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'checkExtensionByMimeType'=>false],
//            [['chart_file_ref_image3'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'checkExtensionByMimeType'=>false],

            [['chart_file'], 'required', 'on'=> 'create']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chart_file' => Yii::t('app', 'Reference Image'),
            'chart_file_ref_image1' => Yii::t('app', 'Ref Image One'),
            'chart_file_ref_image2' => Yii::t('app', 'Ref Image Two'),
            'chart_file_ref_image3' => Yii::t('app', 'Ref Image Three'),
            'chart_title' => Yii::t('app', 'Reference Title'),
            'added_at' => Yii::t('app', 'Added At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

	public function upload($name)
    {
        if ($this->validate()) {
			//$this->banner_file->saveAs(Yii::getAlias('@multefront').'/web/images/upload/' . $name);
			MulteModel::saveFileToServer($this->chart_file->tempName, $name, Yii::$app->params['web_folder']."/chart_file");
            return true;
        } else {
			Yii::$app->session->setFlash('error', $this->errors['chart_file'][0]);
            return false;
        }
    }
    public function uploadRefImageOne($name)
    {
        if ($this->validate()) {
            //$this->banner_file->saveAs(Yii::getAlias('@multefront').'/web/images/upload/' . $name);
            MulteModel::saveFileToServer($this->chart_file_ref_image1->tempName, $name, Yii::$app->params['web_folder']."/chart_file");
            return true;
        } else {
            Yii::$app->session->setFlash('error', $this->errors['chart_file_ref_image1'][0]);
            return false;
        }
    }
    public function uploadRefImageTwo($name)
    {
        if ($this->validate()) {
            //$this->banner_file->saveAs(Yii::getAlias('@multefront').'/web/images/upload/' . $name);
            MulteModel::saveFileToServer($this->chart_file_ref_image2->tempName, $name, Yii::$app->params['web_folder']."/chart_file");
            return true;
        } else {
            Yii::$app->session->setFlash('error', $this->errors['chart_file_ref_image2'][0]);
            return false;
        }
    }
    public function uploadRefImagerThree($name)
    {
        if ($this->validate()) {
            //die("validated");
            //$this->banner_file->saveAs(Yii::getAlias('@multefront').'/web/images/upload/' . $name);
            var_dump(MulteModel::saveFileToServer($this->chart_file_ref_image3->tempName, $name, Yii::$app->params['web_folder']."/chart_file"));
            //die;
            return true;
        } else {
           // die("Not validated");
            Yii::$app->session->setFlash('error', $this->errors['chart_file_ref_image3'][0]);
            return false;
        }
    }
	public function getProduct()
    {
    	return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
