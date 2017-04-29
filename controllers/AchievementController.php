<?php

namespace app\controllers;
use app\models\Achievement;
use app\models\QuestPendingTask;
use app\models\Goal;
use app\models\Badge;
use app\models\Tag;
use app\models\Category;
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


                //Unset Quest
                if( !empty($achievement->quest_id ) ){
                    $qpt = QuestPendingTask::find()->where('quest_id = '.$achievement->quest_id.' and user_id = '.Yii::$app->user->identity->id.'  and status = '.QuestPendingTask::STATUS_PENDING)->one();
                    $qpt->setComplete();
                    $qpt->save();
                }

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
