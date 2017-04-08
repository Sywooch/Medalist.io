<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Scale]].
 *
 * @see Scale
 */
class ScaleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Scale[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Scale|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
