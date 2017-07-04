<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_trace".
 *
 * @property integer $email_trace_id
 * @property string $date_created
 * @property integer $user_id
 * @property string $email
 * @property integer $email_template_id
 * @property integer $status
 * @property string $meta
 * @property integer $counter
 */
class EmailTrace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_trace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_created', 'user_id'], 'required'],
            [['date_created'], 'safe'],
            [['user_id', 'email_template_id', 'status', 'counter'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['meta'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email_trace_id' => 'Email Trace ID',
            'date_created' => 'Date Created',
            'user_id' => 'User ID',
            'email' => 'Email',
            'email_template_id' => 'Email Template ID',
            'status' => 'Status',
            'meta' => 'Meta',
            'counter' => 'Counter',
        ];
    }

    /**
     * @inheritdoc
     * @return EmailTraceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmailTraceQuery(get_called_class());
    }
}
