<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[QuestPendingTask]].
 *
 * @see QuestPendingTask
 */
class QuestPendingTaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return QuestPendingTask[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return QuestPendingTask|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
