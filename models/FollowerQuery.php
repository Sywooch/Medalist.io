<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Follower]].
 *
 * @see Follower
 */
class FollowerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Follower[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Follower|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
