<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property integer $level_id
 * @property integer $level
 * @property integer $scale_points_from
 * @property integer $scale_points_to
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'scale_points_from', 'scale_points_to'], 'required'],
            [['level', 'scale_points_from', 'scale_points_to'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => 'Level ID',
            'level' => 'Level',
            'scale_points_from' => 'Scale Points From',
            'scale_points_to' => 'Scale Points To',
        ];
    }

    /**
     * @inheritdoc
     * @return LevelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LevelQuery(get_called_class());
    }


    public static function getUserLevel( $user_id ){
        $points = ScalePointsBalance::getUserPointsSum( $user_id );

        

        $level = Level::find()->where($points.' BETWEEN scale_points_from AND scale_points_to')->one();
        return $level  ;
    }

    public static function getUserCurrentLevelProgress( $user_id ){
        $level = self::getUserLevel( $user_id );

        $from = $level->scale_points_from;
        $to = $level->scale_points_to;
        $points = ScalePointsBalance::getUserPointsSum( $user_id );

        $points = $points - $from;
        $to = $to - $from;

        return ( $points / $to );
    }
    public static function getUserNextLevelPointsLeft( $user_id ){
        $level = self::getUserLevel( $user_id );

 
        $to = $level->scale_points_to;
        $points = ScalePointsBalance::getUserPointsSum( $user_id );

       
        return (  $to - $points );
    }
}
