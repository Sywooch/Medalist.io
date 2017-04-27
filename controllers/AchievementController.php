<?php

namespace app\controllers;
use app\models\Achievement;
use app\models\QuestPendingTask;
use app\models\Goal;
use app\models\Badge;
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

                //Todo - attachTags
                Tag::attachTagsToObject( $obj, $tagsArray );
                //Todo - attachInterests 

                //Todo - attachCategory 
                //Todo - attachPhotos( Obj )
                if( Badge::addBadgeToUser(Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT, Yii::$app->user->identity->id) ){

                    //TODO возможность передавать массивы  (newAchievement)
                    $result['eventName'] = 'newBadge';
                    $result['eventParams'] =  ['badge_id' => Badge::BDG_ACHIEVEMENT_FIRST_ACHIEVEMENT ];
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

    public function actionAjaxLikeAchievement()
    {
        return $this->render('ajax-like-achievement');
    }

    public function actionAjaxUpdateAchievement()
    {
        return $this->render('ajax-update-achievement');
    }

}
