<?php

namespace app\controllers;

use app\models\Quest;
use app\models\QuestChallenge;
use app\models\QuestChallengeQuery;
use app\models\QuestPendingTask;
use app\models\Badge;
use app\models\Notification;
use app\models\NotificationType;
use Yii;


class QuestController extends \yii\web\Controller
{
    public function actionAjaxTakeQuest()
    {
        $result = [];

        $get = Yii::$app->request->get();

        $quest_id = $get['quest_id'];

        $quest = Quest::findOne( $quest_id );
        $questPendingTastDeadline = strtotime("now +".$quest->deadline_period);

        //Todo check if there is already quest taken
        $questPendingTask = new QuestPendingTask;
        $questPendingTask->deadline = date("Y-m-d H:i:s", $questPendingTastDeadline);
        $questPendingTask->quest_id = $quest_id;
        $questPendingTask->user_id = Yii::$app->user->identity->id;

        $questPendingTask->save();


        //NOTIFICATION - NEW ACHIEVEMENT 
        Notification::addNotification( $questPendingTask->user_id,  NotificationType::NT_QUEST_TAKEN, $quest );


        if( !empty($get['quest_challenge_id']) ){
            $questPendingTask->quest_challenge_id = $get['quest_challenge_id'];
            $questPendingTask->save();
            //TODO NOTIFICATEION -- принял вызов
            $questChallenge = QuestChallenge::findOne( $get['quest_challenge_id'] );
            $questChallenge->status = 1;
            $questChallenge->save();
        }

        //New Event
        //Todo - by quest reward // some stuff
        //Badge Added
        if( Badge::addBadgeToUser( Badge::BDG_QUEST_TAKE_QUEST, Yii::$app->user->identity->id) ){


            //NOTIFICATION - NEW ACHIEVEMENT 
            Notification::addNotification( Yii::$app->user->identity->id,  NotificationType::NT_NEW_REWARD, Badge::findOne(Badge::BDG_QUEST_TAKE_QUEST) );


          $result['eventName'] = 'newBadge';
          $result['eventParams'] =  ['badge_id' => Badge::BDG_QUEST_TAKE_QUEST];
        }


        return json_encode( $result );
    }


    public function actionAjaxRefuseQuestChallenge()
    {
        $result = [];

        $get = Yii::$app->request->get();

        $quest_id = $get['quest_id'];
        $quest_challenge_id = $get['quest_challenge_id'];

        $questChallenge = QuestChallenge::findOne( $quest_challenge_id );

        $result['success']= false;
        if( $questChallenge ){
            if ( $questChallenge->to_user_id == Yii::$app->user->identity->id){

                $questChallenge->status = 9;
                $questChallenge->save();

                $result['success'] = false;
            }
        }
       
  

        return json_encode( $result );
    }






    public function actionAjaxGetQuestPendingTaskHtml(){

        $get = Yii::$app->request->get();
        $quest_id = $get['quest_id'];

        $questPending = QuestPendingTask::find()->where('user_id = '.Yii::$app->user->identity->id.' AND quest_id = '.$quest_id)->one();
        $quest = $questPending->getQuest()->one();

        $html = '<div class="questpending">
                                    <div class="questpending-deadline">До '.$questPending->deadline.'</div>
                                    <div class="questpending-title">'.$quest->name.'</div>
                                    <div class="questpending-description">'.$quest->description.'</div>
                                    <a href="'.Yii::$app->urlManager->createUrl(['personal/achievement-add', 'quest_id'=> $quest->quest_id ]).'" class="questpending-done mdlst-button">Готово!</a>
                            </div>';

        return json_encode(['html' => $html]);


    }




    public function actionAjaxQuestChallengeSend(){

        $result = [];
        $result['test'] = 1;
       

        $post = Yii::$app->request->post();
         $result['post'] =  $post ;

        if ( !empty($post['user_ids'])  && !empty($post['quest_id']) ){
             $result['users'] = [];
                    $result['test'] = 2;
            foreach ($post['user_ids'] as $uid) {
                $result['test'] = 3;
                //TODO проверка друзья или нет (чтобы левым не кидать )
                //TODO проверка что уже бросил такой квест

                $result['users'] = $uid;
                $questChallenge = new QuestChallenge;

                $questChallenge->user_id = Yii::$app->user->identity->id;
                $questChallenge->to_user_id = $uid;
                $questChallenge->quest_id = $post['quest_id'];
                $questChallenge->date_created = date("Y-m-d H:i:s");

                if( $questChallenge->save() ){
                     $result['success'] = true;
                }

            }

        }

        echo  json_encode($result);


    }

}
