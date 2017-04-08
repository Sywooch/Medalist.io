<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[QuestReward]].
 *
 * @see QuestReward
 */
class QuestRewardQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return QuestReward[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return QuestReward|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
