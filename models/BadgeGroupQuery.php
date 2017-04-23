<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BadgeGroup]].
 *
 * @see BadgeGroup
 */
class BadgeGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BadgeGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BadgeGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
