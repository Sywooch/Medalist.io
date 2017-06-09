<?php

/*

       1   Новое достижение    new_achievement
       2   Новая цель  new_goal
       3   Новый квест     new_quest
       4   Новый подписчик     new_follower
       5   Новая награда   new_reward
       6   Цель выполнена  goal_done
       7   Квест пройден   quest_done
       8   Достижение подтверждено     achievement_approved
       9   Новый уровень   new_level
       10   Взят квест   quest_taken
       11 Предложен квест quest_challenge_suggested


*/


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

    const NT_NEW_ACHIEVEMENT = 1;
    const NT_NEW_GOAL = 2;
    const NT_NEW_QUEST = 3;
    const NT_NEW_FOLLOWER = 4;
    const NT_NEW_REWARD = 5;
    const NT_GOAL_DONE = 6;
    const NT_QUEST_DONE = 7;
    const NT_ACHIEVEMENT_APPROVED = 8;
    const NT_NEW_LEVEL = 9;
    const NT_QUEST_TAKEN = 10;
    const NT_QUEST_CHALLENGE_SUGGESTED = 11;

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
