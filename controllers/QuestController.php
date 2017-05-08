<?php

namespace app\controllers;

use app\models\Quest;
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

    public function actionAjaxGetQuestPendingTaskHtml(){

        $get = Yii::$app->request->get();
        $quest_id = $get['quest_id'];

        $questPending = QuestPendingTask::find()->where('user_id = '.Yii::$app->user->identity->id.' AND quest_id = '.$quest_id)->one();
        $quest = $questPending->getQuest()->one();

        $html = '<div class="questpending">
                                    <div class="questpending-deadline">До '.$questPending->deadline.'</div>
                                    <div class="questpending-title">'.$quest->name.'</div>
                                    <div class="questpending-description">'.$quest->description.'</div>
                                    <a href="'.Yii::$app->.'" class="questpending-done mdlst-button">Готово!</a>
                            </div>';

        return json_encode(['html' => $html]);


    }

}
