<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Goal]].
 *
 * @see Goal
 */
class GoalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Goal[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Goal|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
