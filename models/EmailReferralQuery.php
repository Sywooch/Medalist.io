<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmailReferral]].
 *
 * @see EmailReferral
 */
class EmailReferralQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EmailReferral[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EmailReferral|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
