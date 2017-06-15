<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Alarm]].
 *
 * @see Alarm
 */
class AlarmQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Alarm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Alarm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
