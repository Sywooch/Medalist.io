<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "badge_group".
 *
 * @property integer $badge_group_id
 * @property integer $parent_badge_group_id
 * @property string $name
 * @property integer $sort
 */
class BadgeGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'badge_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_badge_group_id', 'name', 'sort'], 'required'],
            [['parent_badge_group_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'badge_group_id' => 'Badge Group ID',
            'parent_badge_group_id' => 'Parent Badge Group ID',
            'name' => 'Name',
            'sort' => 'Sort',
        ];
    }

    /**
     * @inheritdoc
     * @return BadgeGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BadgeGroupQuery(get_called_class());
    }
}
