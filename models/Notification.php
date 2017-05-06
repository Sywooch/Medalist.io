<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $notification_id
 * @property integer $notification_type_id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property string $date_created
 * @property string $text
 * @property string $entity_class
 * @property integer $entity_id
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_type_id', 'user_id', 'to_user_id', 'entity_id'], 'integer'],
            [['user_id', 'date_created', 'text'], 'required'],
            [['date_created'], 'safe'],
            [['text'], 'string'],
            [['entity_class'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'notification_type_id' => 'Notification Type ID',
            'user_id' => 'User ID',
            'to_user_id' => 'To User ID',
            'date_created' => 'Date Created',
            'text' => 'Text',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }

    public function getNotificationType(){
        return $this->hasOne(NotificationType::$className, ['notification_type_id' => 'notification_type_id'])->one();
    }
}
