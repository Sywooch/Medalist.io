<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scale_points_balance".
 *
 * @property integer $scale_points_id
 * @property integer $points
 * @property integer $scale_id
 * @property integer $user_id
 * @property string $date_created
 * @property string $attached_entity_class
 * @property string $attached_entity_id
 */
class ScalePointsBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scale_points_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['points', 'scale_id', 'user_id', 'date_created'], 'required'],
            [['points', 'scale_id', 'user_id', 'attached_entity_id'], 'integer'],
            [['date_created', 'attached_entity_class', 'attached_entity_id'], 'safe'],
            [['attached_entity_class'], 'string', 'max' => 255],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'scale_points_id' => 'Scale Points ID',
            'points' => 'Points',
            'scale_id' => 'Scale ID',
            'user_id' => 'User ID',
            'date_created' => 'Date Created',
            'attached_entity_class' => 'Attached Entity Class',
            'attached_entity_id' => 'Attached Entity ID',
        ];
    }


    public function getScale(){
        return Scale::findOne( $this->scale_id );
    }


    public static function getUserPointsSum( $user_id, $scale = false ){
        $scalePoints = self::find()->where('user_id = '.$user_id)->all();
        $total = 0;
        foreach ($scalePoints as $scalePoint) {
            $total += $scalePoint->points;
        }
        return $total;
    }
    /**
     * @inheritdoc
     * @return ScalePointsBalanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScalePointsBalanceQuery(get_called_class());
    }
}
