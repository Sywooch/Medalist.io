<?php

namespace app\controllers;

use app\models\Achievement;
use app\models\BadgeBalance;
use app\models\BadgeCategory;
use app\models\BadgeGroup;
use app\models\ScalePointsBalance;
use app\models\Badge;
use app\models\Quest;
use app\models\QuestChallenge;
use app\models\QuestPendingTask;
use app\models\Goal;
use app\models\GoalSubtask;
use app\models\Follower;
use app\models\Notification;
use app\models\Interest;
use app\models\Scale;
use app\models\Category;
use app\models\Photo;
use amnah\yii2\user\models\User;
use yii\db\Expression;
use Yii;
use app\models\Like;

class LeaderboardController extends \yii\web\Controller
{

    var $layout = 'medalist_inner';


    public function actionMain()
    {
       $rows = (new \yii\db\Query())
        ->select(['sum(points)', 'user_id'])
        ->from('scale_points_balance') 
        ->orderBy(['sum(points)' => SORT_DESC]) 
        ->groupBy('user_id') 
        ->all();
        	 

             foreach( $rows as $row ){
                    
             }

         return $this->render('main', [
            'rows' =>$rows
        ]);/**/
    }
 

}
