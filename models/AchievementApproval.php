<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "achievement_approval".
 *
 * @property integer $achievement_approval_id
 * @property integer $achievement_id
 * @property string $date_created
 * @property integer $profile_id
 * @property integer $type
 * @property string $meta
 */
class AchievementApproval extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'achievement_approval';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['achievement_id', 'date_created', 'type'], 'required'],
            [['achievement_id', 'profile_id', 'type'], 'integer'],
            [['date_created'], 'safe'],
            [['meta'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'achievement_approval_id' => 'Achievement Approval ID',
            'achievement_id' => 'Achievement ID',
            'date_created' => 'Date Created',
            'profile_id' => 'Profile ID',
            'type' => 'Type',
            'meta' => 'Meta',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new AchievementApprovalQuery(get_called_class());
    }


}
