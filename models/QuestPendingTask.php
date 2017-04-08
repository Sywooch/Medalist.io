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
            [['quest_id', 'deadline'], 'required'],
            [['quest_id', 'quest_challenge_id'], 'integer'],
            [['deadline'], 'safe'],
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
}
