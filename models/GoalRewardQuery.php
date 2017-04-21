<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GoalReward]].
 *
 * @see GoalReward
 */
class GoalRewardQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GoalReward[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GoalReward|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
