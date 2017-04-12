<?php

namespace app\controllers;

use app\models\Quest;
use app\models\QuestChallengeQuery;
use app\models\QuestPendingTask;
use app\models\Badge;
use Yii;


class QuestController extends \yii\web\Controller
{
    public function actionAjaxTakeQuest()
    {
        $result = [];

        $get = Yii::$app->request->get();




        //New Event
        //Todo - by quest reward // some stuff
		$result['eventName'] = 'newBadge';
		$result['eventParams'] =  ['badge_id' => Badge::BDG_QUEST_TAKE_QUEST];


        return json_encode( $result );
    }

}
