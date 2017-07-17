<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_referral".
 *
 * @property integer $email_referral_id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property string $email
 * @property string $date_created
 */
class EmailReferral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_referral';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'email', 'date_created'], 'required'],
            [['user_id', 'to_user_id', 'status'], 'integer'],
            [['date_created','date_accepted'], 'safe'],
            [['email'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email_referral_id' => 'Email Referral ID',
            'user_id' => 'User ID',
            'to_user_id' => 'To User ID',
            'email' => 'Email',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @inheritdoc
     * @return EmailReferralQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmailReferralQuery(get_called_class());
    }
}
