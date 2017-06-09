<?php

namespace app\controllers;
use app\models\Achievement;
use app\models\Quest;
use app\models\QuestPendingTask;
use app\models\Goal;
use app\models\Badge;
use app\models\Tag;
use app\models\Category;
use app\models\Notification;
use app\models\NotificationType;
use app\models\Photo;
use Yii;

class AchievementController extends \yii\web\Controller
{
    //todo - only authorized
    public function actionAjaxAddAchievement()
    {
        $result = [];
        $post = Yii::$app->request->post();

        if( !empty($post) ){
            $achievement = new Achievement;

            //Entity of attachment 
            $ent = $post['entity'];
            $questId = null;
            $goalId = null;
            if( !empty($ent) ){
                $type = substr($ent, 0,1);
                if( $type == 'q'){
                    $quest = QuestPendingTask::find()->where( [ 'quest_id' => substr($ent, 1), 'user_id' => Yii::$app->user->identity->id ] )->one();
                    if( $quest ){
                        $questId = $quest->quest_id;
                    }
                }

                if( $type == 'g'){
                    $goal = Goal::findOne( substr($ent, 1) );
                    if( $goal ){
                        if( $goal->user_id == Yii::$app->user->identity->id  ){
                            $goalId = $goal->goal_id;
                        }
                    }
                }
            }

            //Dates 
            $dateAchieved = $post['date_achieved'];
            $timeAchieved = strtotime($dateAchieved);
            $dateAchievedSql = date("Y-m-d H:i:s", $timeAchieved);

            $achievement->difficult = (int)$post['difficult'];
            $achievement->difficulty = (int)$post['difficulty'];
            $achievement->name = $post['name'];
            $achievement->description = $post['description'];
            $achievement->quest_id = $questId;
            $achievement->goal_id = $goalId;
            $achievement->date_created = date("Y-m-d H:i:s");
            $achievement->user_id = Yii::$app->user->identity->id;
            $achievement->date_achieved = $dateAchievedSql;


            if( $achievement->save() ){


                //NOTIFICATION - NEW ACHIEVEMENT 
                Notification::addNotification( $achievement->user_id,  NotificationType::NT_NEW_ACHIEVEMENT, $achievement );




                if( !empty($post['interests']) ) {
                    //Todo - attachTags
                    Tag::attachTagsToObject( $achievement, $post['interests'] );
                    //Todo - attachInterests 

                    //Todo - attachCategory 
                    $tags = $achievement->getTags();
                    $tagIDs = [];
                    foreach ($tags as $tag) {
                        $tagIDs = $tag->tag_id;
                    }
                    $category_id = Category::getByTagIDs($tagIDs);
                    $achievement->category_id = $category_id;
                    $achievement->save();

                }



                if( !empty($post['files']) ) {
                   

                   foreach ($post['files'] as $file) {
						if ($file == ""){
							continue;
						}
                       $info = pathinfo( $file );
					   $targetFile = './uploads/a/'. $info['basename'];
                       $result2 = rename( $file, $targetFile);


						$newFilename_tb = './uploads/a/'. $info['filename'].'_tb.'.$info['extension'];
						Yii::$app->decor->createThumbnail($targetFile, $newFilename_tb, 431, 285);


                       if ( $result2 ){


                           $photo = new Photo;
                           $photo->filename =  $targetFile;
                           $photo->entity_class  = 'Achievement';
                           $photo->entity_id =  $achievement->achievement_id;
                           $photo->date_created = date("Y-m-d H:i:s");
                           $photo->save();
                        }
                   }
                    
                }



                //Unset Quest
                if( !empty($achievement->quest_id ) ){
                    $qpt = QuestPendingTask::find()->where('quest_id = '.$achievement->quest_id.' and user_id = '.Yii::$app->user->identity->id.'  and status = '.QuestPendingTask::STATUS_PENDING)->one();
                    $qpt->setComplete();
                    $qpt->save();

                    //NOTIFICATION - NEW QUEST DONE 
                    Notification::addNotification( $achievement->user_id,  NotificationType::NT_QUEST_DONE, Quest::findOne($achievement->quest_id) );
                }

                //Todo - attachPhotos( Obj )
                if( Badge::addBadgeToUser(Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT, Yii::$app->user->identity->id) ){

                    //TODO возможность передавать массивы  (newAchievement)
                    $result['eventName'] = 'newBadge';
                    $result['eventParams'] =  ['badge_id' => Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT ];


                    //NOTIFICATION - NEW BADGE 
                    Notification::addNotification( $achievement->user_id,  NotificationType::NT_NEW_REWARD, Badge::findOne(  Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT  ) );
                }
                $result['success'] = true;
            }else{
                $result['error'] = true;
                $result['errors'] = [];
            }
        }

        echo json_encode($result);
    }



//todo - only authorized
    public function actionAjaxUpdateAchievement()
    {
        $result = [];
        $post = Yii::$app->request->post();

        if( !empty($post) && !Yii::$app->user->isGuest ){
            $achievement = Achievement::find()->where( [ 'achievement_id' => $post['achievement_id'] , 'user_id'=> Yii::$app->user->identity->id ] )->one();

            //Entity of attachment 
            $ent = $post['entity'];
            $questId = null;
            $goalId = null;
            if( !empty($ent) ){
                $type = substr($ent, 0,1);
                if( $type == 'q'){
                    $quest = QuestPendingTask::find()->where( [ 'quest_id' => substr($ent, 1), 'user_id' => Yii::$app->user->identity->id ] )->one();
                    if( $quest ){
                        $questId = $quest->quest_id;
                    }
                }

                if( $type == 'g'){
                    $goal = Goal::findOne( substr($ent, 1) );
                    if( $goal ){
                        if( $goal->user_id == Yii::$app->user->identity->id  ){
                            $goalId = $goal->goal_id;
                        }
                    }
                }
            }

            //Dates 
            $dateAchieved = $post['date_achieved'];
            $timeAchieved = strtotime($dateAchieved);
            $dateAchievedSql = date("Y-m-d H:i:s", $timeAchieved);

            $achievement->difficult = (int)$post['difficult'];
            $achievement->difficulty = (int)$post['difficulty'];
            $achievement->name = $post['name'];
            $achievement->description = $post['description'];
            $achievement->quest_id = $questId;
            $achievement->goal_id = $goalId;
            //$achievement->date_created = date("Y-m-d H:i:s");
            $achievement->user_id = Yii::$app->user->identity->id;
            $achievement->date_achieved = $dateAchievedSql;


            if( $achievement->save() ){
 


                if( !empty($post['interests']) ) {
                    //Todo - attachTags
                    Tag::attachTagsToObject( $achievement, $post['interests'] );
                    //Todo - attachInterests 

                    //Todo - attachCategory 
                    $tags = $achievement->getTags();
                    $tagIDs = [];
                    foreach ($tags as $tag) {
                        $tagIDs = $tag->tag_id;
                    }
                    $category_id = Category::getByTagIDs($tagIDs);
                    $achievement->category_id = $category_id;
                    $achievement->save();

                }



                if( !empty($post['files']) ) {
                   

                   foreach ($post['files'] as $file) {
                       $info = pathinfo( $file );
                       $result2 = rename( $file, './uploads/a/'. $info['basename'] );

                       if ( $result2 ){


                           $photo = new Photo;
                           $photo->filename =  '/uploads/a/'. $info['basename'] ;
                           $photo->entity_class  = 'Achievement';
                           $photo->entity_id =  $achievement->achievement_id;
                           $photo->date_created = date("Y-m-d H:i:s");
                           $photo->save();
                        }
                   }
                    
                }



                //Unset Quest
                if( !empty($achievement->quest_id ) ){
                    $qpt = QuestPendingTask::find()->where('quest_id = '.$achievement->quest_id.' and user_id = '.Yii::$app->user->identity->id.'  and status = '.QuestPendingTask::STATUS_PENDING)->one();

                    if  (!empty($qpt)) {
                        
                        $qpt->setComplete();
                        $qpt->save();

                        //NOTIFICATION - NEW QUEST DONE 
                        Notification::addNotification( $achievement->user_id,  NotificationType::NT_QUEST_DONE, Quest::findOne($achievement->quest_id) );
                    }
                }

                //Todo - attachPhotos( Obj )
                if( Badge::addBadgeToUser(Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT, Yii::$app->user->identity->id) ){

                    //TODO возможность передавать массивы  (newAchievement)
                    $result['eventName'] = 'newBadge';
                    $result['eventParams'] =  ['badge_id' => Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT ];


                    //NOTIFICATION - NEW BADGE 
                    Notification::addNotification( $achievement->user_id,  NotificationType::NT_NEW_REWARD, Badge::findOne(  Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT  ) );
                }
                $result['success'] = true;
            }else{
                $result['error'] = true;
                $result['errors'] = [];
            }
        }

        echo json_encode($result);
    }





    public function actionAjaxCommentAchievement()
    {
        return $this->render('ajax-comment-achievement');
    }



    public function actionDeleteAchievement()
    {
         if(  !empty( Yii::$app->request->get()['achievement_id'] ) && !Yii::$app->user->isGuest ){

            $achievement = Achievement::find()->where(['achievement_id' => Yii::$app->request->get()['achievement_id'], 'user_id' => Yii::$app->user->identity->id ])->one();
            if(  $achievement ){

                $photos = $achievement->getPhotos();
                foreach ($photos as $photo) {
                    $photo->deleteFile();
                    $photo->delete();
                }

              Notification::deleteNotificationsOfObj( $achievement );

                $achievement->delete();
                return $this->redirect(['personal/achievements']);
            }else{
                return $this->redirect(['site/index']);
            }

        }else{
            return $this->redirect(['site/index']);
        }
    }

    public function actionAjaxLikeAchievement()
    {
        return $this->render('ajax-like-achievement');
    }


}
