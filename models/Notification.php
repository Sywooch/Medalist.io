<?php

namespace app\models;

use Yii;
use app\models\Achievement;
use amnah\yii2\user\models\User;
/**
 * This is the model class for table "notification".
 *
 * @property integer $notification_id
 * @property integer $notification_type_id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property string $date_created
 * @property string $text
 * @property string $entity_class
 * @property integer $entity_id
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_type_id', 'user_id', 'to_user_id', 'entity_id'], 'integer'],
            [['user_id', 'date_created'], 'required'],
            [['date_created', 'text'], 'safe'],
            [['text'], 'string'],
            [['entity_class'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'notification_type_id' => 'Notification Type ID',
            'user_id' => 'User ID',
            'to_user_id' => 'To User ID',
            'date_created' => 'Date Created',
            'text' => 'Text',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }

    public function getNotificationType(){
        return $this->hasOne(NotificationType::$className, ['notification_type_id' => 'notification_type_id'])->one();
    }



    public static function getUserFeed( $for_user_id, $notification_type_id = false, $limit = 20, $offset = 0  ){

        //GetFriends IDs

        $user_ids = [];

        $followings = Follower::find()->where('user_id ='.$for_user_id)->all();
        foreach( $followings as $following ){
            $user_ids[] = $following->to_user_id;
        }

        
        if( empty($notification_type_id) ){
            $notifications = Notification::find()->where(['to_user_id' => $for_user_id])->orWhere([ 'user_id' => $user_ids]);    
        }else{
             $notifications = Notification::find()->where(['to_user_id' => $for_user_id, 'notification_type_id' => $notification_type_id])->orWhere([ 'user_id' => $user_ids]);    
        }

        $notifications = $notifications->offset( $offset )->limit( $limit );
      

        return $notifications;
        
    }


    /*
    * Добавить новость 
    */
    public static function addNotification($user_id, $notification_type_id, $obj = false, $to_user_id = false, $text = '' ){

        $notification = new Notification;
        $notification->user_id = $user_id;
        $notification->notification_type_id = $notification_type_id;
        $notification->date_created = date("Y-m-d H:i:s");

        if( !empty($obj) ){
            $classname = get_class( $obj );
            $classname = explode("\\",$classname);
            $classname = $classname[count($classname) - 1];
            $idVarName = strtolower($classname."_id");
            $id = $obj->{$idVarName};

            $notification->entity_class = $classname;
            $notification->entity_id = $id;
        }

        if( !empty($to_user_id) ){
            $notification->to_user_id = $to_user_id;
        }

        if( !empty($text) ){
            $notification->text = $text;
        }

        if ( $notification->save() ){
            return $notification->notification_id;
        }else{
            return false;
        }

    }

    public static function deleteNotificationsOfObj ( $obj ){
        $classname = get_class( $obj );
        $classname = explode("\\",$classname);
        $classname = $classname[count($classname) - 1];
        $idVarName = strtolower($classname."_id");
        $id = $obj->{$idVarName};
        

        $notifications =  Notification::find()->where(['entity_class' => $classname,  'entity_id' => $id])->all();
        foreach ($notifications as $n) {

            $n->delete();
            # code...
        }
  
    }


    public static function renderNotificationHTML( $notification ){


        //Getting Object 
        if( $notification->entity_class != 'User'){
            $className = "app\models\\".$notification->entity_class;
        }else{
            $className = "amnah\yii2\user\models\User";
        }
        $model = Yii::createObject([
          'class' => $className,
         ]);
       
        $obj  = $model::findOne( $notification->entity_id );
        
        if( empty($obj )) { return false; }

      //  if( $notification->notification_type_id == NotificationType::NT_NEW_FOLLOWER ){ var_dump( $obj->to_user_id ); return false; }
    
        //Getiing User
        $userCreatedNew = User::find()->where('id = '.$notification->user_id)->one();


        ?>
            <div class="newblock">
                <div class="newblock-pic">
     	             <a href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $userCreatedNew->id])?>" class="newblock-pic-name"><?=$userCreatedNew->getName()?></a> 
        			<a href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $userCreatedNew->id])?>" class="newblock-pic-userlink" style="background-image: url(<?=Yii::$app->decor->getThumbnail($userCreatedNew->getProfile()->one()->getAvatarSrc());?>);">
        			</a>

		          </div>

                <div class="newblock-data">

                    <?php 
                        switch ($notification->notification_type_id) {
                            case NotificationType::NT_NEW_FOLLOWER:

                                //obj of User
                                ?>
				<div class="newblock-data-text">
		                    <span class="not-date"><?=date("d.m.Y", strtotime($notification->date_created) );?></span>
					Подписка на обновления пользователя 
				</div>
		                <div class="newblock-pic-user-to">
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $obj->to_user_id])?>" class="newblock-pic-name"><?=$obj->getUser()->getName()?></a>
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/viewprofile','user_id' => $obj->to_user_id])?>" class="newblock-pic-userlink" style="background-image: url(<?=Yii::$app->decor->getThumbnail($obj->getUser()->getProfile()->one()->getAvatarSrc());?>);"></a>
				</div>
                                <?
                                break;
                            
                            case NotificationType::NT_NEW_ACHIEVEMENT:

                                //obj of User
                                ?>
				<div class="newblock-data-text">
					<span class="not-date"><?=date("d.m.Y", strtotime($obj->date_achieved) );?></span>
					Новое достижение<!----> <a href="<?=Yii::$app->urlManager->createUrl( ['personal/achievement','achievement_id' => $obj->achievement_id])?>"><?=$obj->name?></a>
					<p class="newblock-desc"> <?=$obj->description?></p>
				</div>
		                <div class="newblock-pic-user-to">
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/achievement','achievement_id' => $obj->achievement_id])?>" class="newblock-pic-name"><?=$obj->name?></a>
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/achievement','achievement_id' => $obj->achievement_id])?>" class="newblock-pic-userlink" <?php if(!empty($obj->getPhotos()[0]) ) { ?> style = "background-image: url(<?=Yii::$app->decor->getThumbnail($obj->getPhotos()[0]->filename)?>);"<? } ?>></a>
				</div>
                                <?
                                break;
                            case NotificationType::NT_NEW_REWARD:

                                //obj of User
                                ?>
				<div class="newblock-data-text">
		                    <span class="not-date"><?=date("d.m.Y", strtotime($notification->date_created) );?></span>
        	       	                Новая награда <a href="<?=Yii::$app->urlManager->createUrl( ['personal/reward-detail','badge_id' => $obj->badge_id])?>"><?=$obj->name?></a>
					<p class="newblock-desc"> <?=$obj->description?></p>
				</div>
		                <div class="newblock-pic-user-to">
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/reward-detail','badge_id' => $obj->badge_id])?>" class="newblock-pic-name"><?=$obj->name?></a>
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/reward-detail','badge_id' => $obj->badge_id])?>" class="newblock-pic-userlink" <?php if(!empty($obj->picture_small) ) { ?> style = "background-size: 100px 75px; background-repeat: no-repeat; background-image: url(<?=$obj->picture_small;?>);"<? } ?>></a>
				</div>
                                <?
                                break;
                            case NotificationType::NT_NEW_LEVEL:

                                //obj of User
                                ?>
				<div class="newblock-data-text">
		                    <span class="not-date"><?=date("d.m.Y", strtotime($notification->date_created) );?></span>
	                                Достижение нового уровня  <b><?=$obj->level?></b>
				</div>
                                <?
                                break;

                            case NotificationType::NT_QUEST_TAKEN:

                                //obj of User
                                ?>
				<div class="newblock-data-text">
		                    <span class="not-date"><?=date("d.m.Y", strtotime($notification->date_created) );?></span>
        	                      Взят квест <a href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' => $obj->quest_id])?>"><?=$obj->name?></a>
					<p class="newblock-desc"> <?=$obj->description?></p>
				</div>
		                <div class="newblock-pic-user-to">
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' => $obj->quest_id])?>" class="newblock-pic-name"><?=$obj->name?></a>
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' => $obj->quest_id])?>" class="newblock-pic-userlink" <?php if(!empty($obj->picture) ) { ?> style = "background-image: url(<?=$obj->picture?>);"<? } ?>></a>
				</div>

                                <?
                                break;

                            case NotificationType::NT_NEW_GOAL:

                                //obj of User
                                ?>
				<div class="newblock-data-text">
		                    <span class="not-date"><?=date("d.m.Y", strtotime($notification->date_created) );?></span>
        	                        Новая цель <a href="<?=Yii::$app->urlManager->createUrl( ['personal/goal','goal_id' => $obj->goal_id])?>"><?=$obj->name?></a>
					<p class="newblock-desc"> <?=$obj->description?></p>
				</div>
		                <div class="newblock-pic-user-to">
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/goal','goal_id' => $obj->goal_id])?>" class="newblock-pic-name"><?=$obj->name?></a>
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/goal','goal_id' => $obj->goal_id])?>" class="newblock-pic-userlink" <?php if(!empty($obj->getPhotos()[0]) ) { ?> style = "background-image: url(<?=Yii::$app->decor->getThumbnail($obj->getPhotos()[0]->filename)?>);"<? } ?>></a>
				</div>

                                <?
                                break;

                            case NotificationType::NT_QUEST_DONE:

                                //obj of User
                                ?>
				<div class="newblock-data-text">
		                    <span class="not-date"><?=date("d.m.Y", strtotime($notification->date_created) );?></span>
	                                Выполнен квест <a href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' => $obj->quest_id])?>"><?=$obj->name?></a>
					<p class="newblock-desc"> <?=$obj->description?></p>
				</div>
		                <div class="newblock-pic-user-to">
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' => $obj->quest_id])?>" class="newblock-pic-name"><?=$obj->name?></a>
					<a href="<?=Yii::$app->urlManager->createUrl( ['personal/quest','quest_id' => $obj->quest_id])?>" class="newblock-pic-userlink" <?php if(!empty($obj->picture) ) { ?> style = "background-image: url(<?=$obj->picture?>);"<? } ?>></a>
				</div>
                                <?
                                break;
                            
                            default:
                                echo $notification->notification_type_id;
                                break;
                        }
                    ?>

                    <br />
                </div>


                <div class="newblock-icon">
                     <?php 
                        switch ($notification->notification_type_id) {
                            case NotificationType::NT_NEW_FOLLOWER:

                                //obj of User
                                ?>
                                <img src="/template/img/new-icon-follower.png" alt="">
                                <?
                                break;
                            
                            case NotificationType::NT_NEW_ACHIEVEMENT:

                                //obj of User
                                ?>
                                <img src="/template/img/new-icon-achievement.png" alt="">
                                <?
                                break;
                            
                            case NotificationType::NT_NEW_GOAL:

                                //obj of User
                                ?>
                                <img src="/template/img/new-icon-goal.png" alt="">
                                <?
                                break;
                         
                            
                            default:
                                
                                break;
                        }
                    ?>
                </div>
            </div>
        <?

    }


}
