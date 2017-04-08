<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quest_reward".
 *
 * @property integer $quest_reward_id
 * @property integer $quest_id
 * @property integer $type
 * @property integer $scale_id
 * @property integer $points
 * @property integer $badge_id
 * @property integer $lurms
 */
class QuestReward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quest_id', 'type'], 'required'],
            [['quest_id', 'type', 'scale_id', 'points', 'badge_id', 'lurms'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quest_reward_id' => 'Quest Reward ID',
            'quest_id' => 'Quest ID',
            'type' => 'Type',
            'scale_id' => 'Scale ID',
            'points' => 'Points',
            'badge_id' => 'Badge ID',
            'lurms' => 'Lurms',
        ];
    }

    /**
     * @inheritdoc
     * @return QuestRewardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestRewardQuery(get_called_class());
    }
}
