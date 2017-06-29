<?php

namespace app\controllers;

use app\models\Quest;
use app\models\QuestChallenge;
use app\models\QuestChallengeQuery;
use app\models\QuestPendingTask;
use app\models\Badge;
use app\models\Notification;
use app\models\NotificationType;
use app\models\ScalePointsBalance;
use app\models\Alarm;
use app\models\EmailTemplate;
use amnah\yii2\user\models\User;
use Yii;
use yii\helpers\BaseUrl;


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


          //BaseAchievement
        ScalePointsBalance::addBalance($questPendingTask->user_id, ScalePointsBalance::BASE_QUEST_TAKEN_SCALE, ScalePointsBalance::BASE_QUEST_TAKEN_POINTS, "Quest", $questPendingTask->quest_id);


        //NOTIFICATION - NEW ACHIEVEMENT 
        Notification::addNotification( $questPendingTask->user_id,  NotificationType::NT_QUEST_TAKEN, $quest );


        if( !empty($get['quest_challenge_id']) ){
            $questPendingTask->quest_challenge_id = $get['quest_challenge_id'];
            $questPendingTask->save();
            //TODO NOTIFICATEION -- принял вызов
            $questChallenge = QuestChallenge::findOne( $get['quest_challenge_id'] );
            $questChallenge->status = 1;
            $questChallenge->save();

              //Reversed because it is response
                Alarm::addAlarm( $questChallenge->to_user_id  ,  $questChallenge->user_id , Alarm::TYPE_QUEST_CHALLENGE_ACCEPTED, false , 'Quest', $questChallenge->quest_id );


        }

        //New Event
        //Todo - by quest reward // some stuff
        //Badge Added
        if( Badge::addBadgeToUser( Badge::BDG_QUEST_TAKE_QUEST, Yii::$app->user->identity->id, 'Quest', $quest_id) ){


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
                //Reversed because it is response
                Alarm::addAlarm( $questChallenge->to_user_id  ,  $questChallenge->user_id , Alarm::TYPE_QUEST_CHALLENGE_REFUSED, false , 'Quest', $questChallenge->quest_id );

                $result['success'] = true;
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

                     Alarm::addAlarm( $questChallenge->user_id ,  $questChallenge->to_user_id  , Alarm::TYPE_QUEST_CHALLENGE, false , 'Quest', $questChallenge->quest_id );
                     $result['success'] = true;


                     //EMAIL NOTIFICATEION
                     $email = EmailTemplate::findOne( EmailTemplate::NEW_QUEST_CHALLENGE );
                      // [QUEST_NAME, QUEST_URL, QUEST_IMAGE_URL, QUEST_LIST_URL, TO_NAME, FROM_NAME]
                     $toUser = User::findOne( $uid );
                     $fromUser = User::findOne( Yii::$app->user->identity->id );
                     $quest = Quest::findOne( $uid );

                     $email->send($toUser->email, [
                        'QUEST_NAME' => $quest->name,
                        'QUEST_URL' => BaseUrl::base(true).Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $quest->quest_id]),
                        'QUEST_IMAGE_URL' =>  BaseUrl::base(true).'/'.$quest->picture,
                        'QUEST_LIST_URL' => BaseUrl::base(true).Yii::$app->urlManager->createUrl(['personal/quests']),
                        'TO_NAME' => $toUser->getName(),
                        'FROM_NAME' => $fromUser->getName()

                    ]);
                     //EMAIL NOTIFICATEION END 
                }

            }

        }

        echo  json_encode($result);


    }


    //Просроченные квесты
    public function actionCronQuestTaskExpire(){

        $questTasksExpired = QuestPendingTask::find()
                                    ->where(['status' => 0])
                                    ->andWhere(['<', 'deadline', date("Y-m-d H:i:s")])
                                    ->all();
        foreach ($questTasksExpired as $task) {
            var_dump($task);


            $email = EmailTemplate::findOne( EmailTemplate::QUEST_DEADLINE_EXPIRED );

            $toUser = User::findOne( $task->user_id );
            $quest = Quest::findOne( $task->quest_id );

            $email->send( $toUser->email, [
                'QUEST_NAME' => $quest->name,
                'QUEST_URL' => BaseUrl::base(true).Yii::$app->urlManager->createUrl(['personal/quest', 'quest_id' => $quest->quest_id]),
                'TO_NAME' => $toUser->getName()
                ]);

            $task->status = 3; //Expired
            $task->save();
        }
    }

}
