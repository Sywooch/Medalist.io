<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goal_reward".
 *
 * @property integer $goal_reward_id
 * @property integer $goal_id
 * @property integer $type
 * @property integer $scale_id
 * @property integer $points
 * @property integer $badge_id
 * @property integer $lurms
 */
class GoalReward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goal_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goal_id', 'lurms'], 'required'],
            [['goal_id', 'type', 'scale_id', 'points', 'badge_id', 'lurms'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goal_reward_id' => 'Goal Reward ID',
            'goal_id' => 'Goal ID',
            'type' => 'Type',
            'scale_id' => 'Scale ID',
            'points' => 'Points',
            'badge_id' => 'Badge ID',
            'lurms' => 'Lurms',
        ];
    }

    /**
     * @inheritdoc
     * @return GoalRewardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GoalRewardQuery(get_called_class());
    }
}
