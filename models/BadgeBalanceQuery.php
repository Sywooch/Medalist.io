<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BadgeBalance]].
 *
 * @see BadgeBalance
 */
class BadgeBalanceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BadgeBalance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BadgeBalance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
