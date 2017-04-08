<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "achievement_album".
 *
 * @property integer $achievement_album_id
 * @property integer $achievement_id
 * @property integer $name
 */
class AchievementAlbum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'achievement_album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['achievement_id'], 'required'],
            [['achievement_id', 'name'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'achievement_album_id' => 'Achievement Album ID',
            'achievement_id' => 'Achievement ID',
            'name' => 'Name',
        ];
    }

    /**
     * @inheritdoc
     * @return AchievementAlbumQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AchievementAlbumQuery(get_called_class());
    }
}
