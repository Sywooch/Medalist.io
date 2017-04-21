<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GoalSubtask]].
 *
 * @see GoalSubtask
 */
class GoalSubtaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GoalSubtask[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GoalSubtask|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
