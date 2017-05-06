<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification_type".
 *
 * @property integer $notification_type_id
 * @property string $name
 * @property string $code
 */
class NotificationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_type_id' => 'Notification Type ID',
            'name' => 'Name',
            'code' => 'Code',
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationTypeQuery(get_called_class());
    }
}
