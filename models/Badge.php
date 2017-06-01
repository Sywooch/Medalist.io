<?php

namespace app\models;

use Yii;
use Yii\db\Query;

/**
 * This is the model class for table "badge".
 *
 * @property integer $badge_id
 * @property string $name
 * @property string $description
 * @property string $picture
 * @property string $picture_small
 * @property integer $secret
 * @property integer $active
 * @property integer $badge_group_id
 */
class Badge extends \yii\db\ActiveRecord
{

    const BDG_WELCOME = 1;
    
    const BDG_QUEST_TAKE_QUEST = 2;
    const BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'badge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'picture', 'picture_small', 'secret', 'active', 'badge_group_id'], 'required'],
            [['description'], 'string'],
            [['secret', 'active', 'badge_group_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['picture', 'picture_small'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'badge_id' => 'Badge ID',
            'name' => 'Name',
            'description' => 'Description',
            'picture' => 'Picture',
            'picture_small' => 'Picture Small',
            'secret' => 'Secret',
            'active' => 'Active',
            'badge_group_id' => 'Badge Group ID',
        ];
    }

    /**
     * @inheritdoc
     * @return BadgeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BadgeQuery(get_called_class());
    }


    /**
    *
    */
    public static function addBadgeToUser( $badge_id, $user_id ){

        $badge = self::findOne( $badge_id );


        //Todo Check if user had this badge
        $badgeExists = BadgeBalance::find()->where('badge_id = '.$badge_id.' AND user_id = '.$user_id)->one();

        if( !$badgeExists ){


            //Adding Badge Balance
			BadgeBalance::addBalance($user_id, $badge_id);

/*
            $badgeBalance = new BadgeBalance; 
            $badgeBalance->user_id = $user_id; 
            $badgeBalance->badge_id = $badge_id; 
            $badgeBalance->date_created = date("Y-m-d H:i:s"); 
            $badgeBalance->save();
*/     

            //Getting Scale Points 

            $q = new Query();
            $row = $q->select(['scale_id', 'points'])->from('badge_scale_points')->where('badge_id = '.$badge_id)->one();

             
            //Adding Scale Points Balance
			ScalePointsBalance::addBalance($user_id, $row['scale_id'], $row['points'], "Badge", (int)$badge_id);

/*
            $scalePointsBalance = new ScalePointsBalance;
            $scalePointsBalance->scale_id = $row['scale_id'];
            $scalePointsBalance->points = $row['points'];
            $scalePointsBalance->date_created = date("Y-m-d H:i:s");
            $scalePointsBalance->user_id = $user_id;
            $scalePointsBalance->attached_entity_class = "Badge";
            $scalePointsBalance->attached_entity_id =  (int)$badge_id;
            $scalePointsBalance->save();
*/
            return true;

        }else{
            return false;
        }

 

    }



    /**
    * Сколько какой шкалы даётся за получение бейджа
    */
    public function getBadgeScalePoints(){
        $q = new Query();
        $row = $q->select(['scale_id', 'points'])->from('badge_scale_points')->where('badge_id = '.$this->badge_id)->one();
        return   array('points' => $row['points'], 'scale_id' => $row['scale_id'], 'scale' => Scale::findOne($row['scale_id']));
    }

    /**
    * Сколько человек получили этот бейдж
    */
    public function getAchievedUserCount(){
        $q = new Query();
        $row = $q->select(['count(*)'])->from('badge_balance')->where('badge_id = '.$this->badge_id)->one();
        return $row['count(*)'];
    }
    /**
    * Сколько человек получили этот бейдж
    */
    public function getAchievedUsers(){
        $q = new Query();
        $rows= $q->select(['user_id'])->from('badge_balance')->where('badge_id = '.$this->badge_id)->distinct()->all();
        return $rows;
    }

}
