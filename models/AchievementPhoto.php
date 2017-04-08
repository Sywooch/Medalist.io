<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "achievement_photo".
 *
 * @property integer $achievement_photo_id
 * @property integer $achievement_album_id
 * @property string $src
 * @property string $date_created
 */
class AchievementPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'achievement_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['achievement_album_id', 'src', 'date_created'], 'required'],
            [['achievement_album_id'], 'integer'],
            [['date_created'], 'safe'],
            [['src'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'achievement_photo_id' => 'Achievement Photo ID',
            'achievement_album_id' => 'Achievement Album ID',
            'src' => 'Src',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @inheritdoc
     * @return AchievementPhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AchievementPhotoQuery(get_called_class());
    }
}
