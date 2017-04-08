<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[QuestChallenge]].
 *
 * @see QuestChallenge
 */
class QuestChallengeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return QuestChallenge[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return QuestChallenge|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
