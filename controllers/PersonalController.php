<?php

namespace app\controllers;


use app\models\BadgeBalance;
use app\models\BadgeCategory;
use app\models\BadgeGroup;
use app\models\ScalePointsBalance;
use app\models\Badge;
use app\models\Quest;
use app\models\QuestPendingTask;
use app\models\Goal;
use app\models\GoalSubtask;
use Yii;

class PersonalController extends \yii\web\Controller
{
    var $layout = 'medalist_inner';

    //todo - protect from unuthorized

    public function actionAchievements()
    {
        return $this->render('achievements');
    }

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    public function actionFriends()
    {
        return $this->render('friends');
    }

    public function actionGoals()
    {
        //$id = Yii::$app->request->get()['goal_id'];
        $goal = Goal::find()->all();
        return $this->render('goals');
    }

    public function actionGoal()
    {

        $id = Yii::$app->request->get()['goal_id'];
        $goal = Goal::findOne( $id );
        return $this->render('goal', ['goal' => $goal]);
    }

    public function actionNews()
    {
        return $this->render('news');
    }

    public function actionQuests()
    {

        //Todo подбор интересных квестов

        $questPendingTasks = QuestPendingTask::find()->where('user_id = '.Yii::$app->user->identity->id.' AND status = 0')->all();
        $excludeIds = [];
        foreach($questPendingTasks as $pt ){
            $excludeIds[] = $pt->quest_id;
        }

        $quests = Quest::find()->where(['not in', 'quest_id', $excludeIds])->all();

        return $this->render('quests', ['quests' => $quests, 'questsPending' => $questPendingTasks]);
    }



    public function actionRewards()
    {

        $user_id = Yii::$app->user->identity->id;

        $badgeBalance = BadgeBalance::find()->where('user_id = '.$user_id)->all();
        $badges = [];
        foreach( $badgeBalance as $bb ){
            $badges[] = $bb;

        }

        $badgeGroups = BadgeGroup::find()->all();
        $badgeTotal = Badge::find()->all();

        return $this->render('rewards', ['badges' => $badges, 'badgeGroups' => $badgeGroups, 'badgeTotal' => $badgeTotal]);
    }

    

    public function actionRewardDetail()
    {

        $get = Yii::$app->request->get();

        $badge = Badge::findOne( $get['badge_id'] );
        

        return $this->render('reward-detail', ['badge' => $badge]);
    }


    public function actionSettings()
    {
        return $this->render('settings');
    }

}
