<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AchievementAlbum]].
 *
 * @see AchievementAlbum
 */
class AchievementAlbumQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AchievementAlbum[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AchievementAlbum|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
