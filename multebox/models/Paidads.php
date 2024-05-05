<?php

namespace multebox\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Html;

/**
 * This is the model class for table "tbl_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $about
 * @property integer $user_type_id
 * @property integer $active
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $added_at
 * @property integer $updated_at
 */
class Paidads extends ActiveRecord
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;
	const ROLE_USER = 1;
	public $auth_key='';
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
//        return [
//            [['username', 'email', 'first_name', 'last_name', 'user_type_id'], 'required'],
//            [['about','entity_type'], 'string'],
//            [['user_type_id', 'active',  'added_at', 'updated_at','entity_id'], 'integer'],
//            [['username', 'email','password_hash', 'first_name', 'last_name'], 'string', 'max' => 255],
//            [['auth_key'], 'string', 'max' => 32],
//			[[ 'email'],'email'],
//			[['email','username'],'unique']
//        ];
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
