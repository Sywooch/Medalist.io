<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Badge]].
 *
 * @see Badge
 */
class BadgeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Badge[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Badge|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
