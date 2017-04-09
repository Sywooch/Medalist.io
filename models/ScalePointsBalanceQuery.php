<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ScalePointsBalance]].
 *
 * @see ScalePointsBalance
 */
class ScalePointsBalanceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ScalePointsBalance[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScalePointsBalance|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
