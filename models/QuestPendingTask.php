<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quest_pending_task".
 *
 * @property integer $quest_pending_task_id
 * @property integer $quest_id
 * @property integer $quest_challenge_id
 * @property string $deadline
 */
class QuestPendingTask extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_REFUSED = 2;
    const STATUS_EXPIRED = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_pending_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quest_id', 'deadline', 'user_id'], 'required'],
            [['quest_id', 'quest_challenge_id', 'user_id'], 'integer'],
            [['deadline', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quest_pending_task_id' => 'Quest Pending Task ID',
            'quest_id' => 'Quest ID',
            'quest_challenge_id' => 'Quest Challenge ID',
            'deadline' => 'Deadline',
        ];
    }

    /**
     * @inheritdoc
     * @return QuestPendingTaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestPendingTaskQuery(get_called_class());
    }

    public function getQuest(){
        return $this->hasOne( Quest::className(), ['quest_id' => 'quest_id'] );
    }

    public function setComplete(){
        $this->status = self::STATUS_COMPLETE;
    }
}
