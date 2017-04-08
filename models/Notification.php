<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $notification_id
 * @property integer $to_user_id
 * @property integer $date_created
 * @property integer $created_by_id
 * @property string $text
 * @property integer $readed
 * @property string $entity_class
 * @property integer $entity_id
 * @property string $type
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
            [['to_user_id', 'date_created', 'text'], 'required'],
            [['to_user_id', 'date_created', 'created_by_id', 'readed', 'entity_id'], 'integer'],
            [['text'], 'string'],
            [['entity_class', 'type'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'to_user_id' => 'To User ID',
            'date_created' => 'Date Created',
            'created_by_id' => 'Created By ID',
            'text' => 'Text',
            'readed' => 'Readed',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
            'type' => 'Type',
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
}
