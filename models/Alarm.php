<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alarm".
 *
 * @property integer $alarm_id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $date_created
 * @property string $text
 * @property integer $alarm_type
 * @property string $entity_class
 * @property integer $entity_id
 */
class Alarm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alarm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'date_created', 'alarm_type'], 'required'],
            [['from_user_id', 'to_user_id', 'alarm_type', 'entity_id'], 'integer'],
            [['date_created'], 'safe'],
            [['text'], 'string', 'max' => 1024],
            [['entity_class'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'alarm_id' => 'Alarm ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'date_created' => 'Date Created',
            'text' => 'Text',
            'alarm_type' => 'Alarm Type',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @inheritdoc
     * @return AlarmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlarmQuery(get_called_class());
    }
}
