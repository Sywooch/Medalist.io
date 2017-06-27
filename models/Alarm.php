<?php

namespace app\models;

use Yii;
use amnah\yii2\user\models\User;
use app\models\Achievement;
use app\models\Goal;
use app\models\Follower;
use app\models\Badge;
use app\models\BadgeBalance;
/**
 * This is the model class for table "alarm".
 *
 * @property integer $alarm_id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $date_created
 * @property string $text
 * @property integer $alarm_type
 * @property string $entity_class
 * @property integer $entity_id
 */
class Alarm extends \yii\db\ActiveRecord
{

    const TYPE_LIKE = 1;
    const TYPE_COMMENT = 2;
    const TYPE_QUEST_CHALLENGE = 3;
    const TYPE_YOU_ARE_FOLLOWED = 4;
    const TYPE_ACHIEVEMENT_APPROVED = 5;
    const TYPE_QUEST_CHALLENGE_ACCEPTED = 6;
    const TYPE_QUEST_CHALLENGE_REFUSED = 7;
    const TYPE_REWARD = 8;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alarm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to_user_id', 'date_created', 'alarm_type'], 'required'],
            [['from_user_id', 'to_user_id', 'alarm_type', 'status', 'traced', 'entity_id'], 'integer'],
            [['date_created'], 'safe'],
            [['text'], 'string', 'max' => 1024],
            [['entity_class'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'alarm_id' => 'Alarm ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'date_created' => 'Date Created',
            'text' => 'Text',
            'status' => 'Status',
            'alarm_type' => 'Alarm Type',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @inheritdoc
     * @return AlarmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlarmQuery(get_called_class());
    }

    public static function addAlarm( $userFrom = false, $userTo = false, $alarmType = false, $text = false, $entity_class = false, $entity_id = false ){

        //No alarms to yourself 
        if( $userFrom === $userTo ){
            return false;
        }


        //Checl alarmas 
        if( !empty($userFrom) ){
            $exists = Alarm::find()->where(['to_user_id' => $userTo,'from_user_id' => $userFrom,'alarm_type' => $alarmType,'entity_class' => $entity_class,'entity_id' => $entity_id])->all();
        }else{
            $exists = Alarm::find()->where([ 'to_user_id' => $userTo,'alarm_type' => $alarmType,'entity_class' => $entity_class,'entity_id' => $entity_id])->all();
        }

        if( $exists ){
            return false;
        }
        


        $alarm = new Alarm;
        if( !empty($userFrom) ){
            $alarm->from_user_id = $userFrom;    
        }
        
        $alarm->to_user_id = $userTo;
        $alarm->alarm_type = $alarmType;

        if( !empty($text) ){
            $alarm->text = $text; 
        }
        if( !empty($entity_class) ){
            $alarm->entity_class = $entity_class; 
        }
        if( !empty($entity_id) ){
            $alarm->entity_id = $entity_id; 
        }
        $alarm->status = 0;
        $alarm->traced = 0;
        $alarm->date_created = date("Y-m-d H:i:s");
        if( $alarm->save() ){
            return true;    
        }else{
            return false;
        }
        
    }

    public function getUserFrom(){
        return User::find()->where(['id' => $this->from_user_id]);
    }

    public function getUserTo(){
        return User::find()->where(['id' => $this->to_user_id]);
    }

    protected static function anonymAlarms(){
        return [5];
    }






    public static function renderAlarmBlockHTML( $alarmId, $big = false){

        if( !is_object($alarmId) ){
            $alarm = Alarm::findOne($alarmId);    
        }else{
            $alarm =  $alarmId;  
        }
        

        $class = ($big == true )?"notificationslist":"notifications";
         
        $fromUser = false;
         if( !empty($alarm->from_user_id) ){
             $fromUser = $alarm->getUserFrom()->one();
         }

        
                    ?>
                <div class="<?=$class?>-block <? if($alarm->status == 0 ) { ?><?=$class?>-block__new <? } ?> h-alarm-block" data-alarm_id="<?=$alarm->alarm_id?>">
                    <div class="<?=$class?>-block-user">
                        <?php if ($fromUser) { ?>
                        <div class="<?=$class?>-block-user-pic" style="background-image: url(<?=$fromUser->getProfile()->one()->getAvatarSrc()?>)"></div>
                        <? } ?>
                    </div>
                    <div class="<?=$class?>-block-text">
                         <?php if ($fromUser) { ?>
                        <a href="<?=Yii::$app->urlManager->createUrl(['personal/viewprofile', 'user_id' => $fromUser->id]);?>"><?=$fromUser->getName();?></a> 
                        <? } ?>

                        <?php switch($alarm->alarm_type) {
                                case 1:
                                ?>
                                        оценил 
                                        <? switch( $alarm->entity_class) {

                                            case "Achievement":
                                                $obj = Achievement::findOne( $alarm->entity_id);
                                                ?>
                                                    ваше достижение <a href="<?=Yii::$app->urlManager->createUrl(['personal/achievement', 'achievement_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
                                                <?
                                            break;
                                            case "Goal":
                                                $obj = Goal::findOne( $alarm->entity_id);
                                                ?>
                                                    вашу цель <a href="<?=Yii::$app->urlManager->createUrl(['personal/goal', 'goal_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
                                                <?
                                            break;


                                            } ?>
                                <?
                                break;
                                case 2:
                                ?>
                                        прокомментировал 
                                        <? switch( $alarm->entity_class) {

                                            case "Achievement":
                                                $obj = Achievement::findOne( $alarm->entity_id);
                                                ?>
                                                    ваше достижение <a href="<?=Yii::$app->urlManager->createUrl(['personal/achievement', 'achievement_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
                                                <?
                                            break;
                                            case "Goal":
                                                $obj = Goal::findOne( $alarm->entity_id);
                                                ?>
                                                    вашу цель <a href="<?=Yii::$app->urlManager->createUrl(['personal/goal', 'goal_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
                                                <?
                                            break;
                                            case "Comment":
                                                $obj = Comment::findOne( $alarm->entity_id);
                                                $commentedObj =  $obj->getObject();
                                                ?>
                                                    ваш ответ к <a href="<?=$obj->getObjectUrl();?>"><?=$commentedObj->name?></a>
                                                <?
                                            break;


                                            } ?>
                                <?
                                break;
                                case 3:
                                ?>
                                        бросил вам вызов в квесте 
                                        <?  
                                                $obj = Quest::findOne( $alarm->entity_id);
                                                ?>
                                                   <a href="<?=Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
                                                <?
                                            


                                              ?>
                                <?
                                break;
                                case 4:
                                ?>
                                        подписался на ваши обновления 
                                         
                                <?
                                break;
                                case 5:
                                ?>
                                      <? switch( $alarm->entity_class) {

                                            case "Achievement":
                                                $obj = Achievement::findOne( $alarm->entity_id);
                                                ?>
                                                   Ваше достижение <a href="<?=Yii::$app->urlManager->createUrl(['personal/achievement', 'achievement_id' => $alarm->entity_id]);?>"><?=$obj->name?></a> подтверждено
                                                <?
                                            break; 


                                            } ?>
                                         
                                <?
                                break;


                                case 6:
                                ?>
                                        СОГЛАСИЛСЯ участвовать в квесте 
                                        <?  
                                                $obj = Quest::findOne( $alarm->entity_id);
                                                ?>
                                                   <a href="<?=Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
                                                <?
                                            


                                              ?>
                                <?
                                break;



                                case 7:
                                ?>
                                       ОТКАЗАЛСЯ участвовать в квесте 
                                        <?  
                                                $obj = Quest::findOne( $alarm->entity_id);
                                                ?>
                                                   <a href="<?=Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $alarm->entity_id]);?>"><?=$obj->name?></a>
                                                <?
                                            


                                              ?>
                                <?
                                break;

                                case 8:
                                ///index.php?r=personal%2Freward-detail&badge_id=1&badge_balance_id=70
                                ?>
                                       У вас новая награда 
                                        <?  
                                                $badgeBalance = BadgeBalance::findOne( $alarm->entity_id);
                                                $obj = Badge::findOne( $badgeBalance->badge_id);
                                                ?>
                                                   <a href="<?=Yii::$app->urlManager->createUrl(['personal/reward-detail', 'badge_id' => $obj->entity_id, 'badge_balance_id' => $badgeBalance->badge_id]);?>"><?=$obj->name?></a>
                                                <?
                                            


                                              ?>
                                <?
                                break;

                            }?>

                        <?php if($big) { 
                                echo "<br><span style='color: gray'>".date("d.m.Y в H:i:s", strtotime($alarm->date_created))."</span>";
                         }?>
                    
                    </div>
                </div> 
              


        <?
    }


}
