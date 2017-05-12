<?php

namespace app\controllers;


use app\models\Achievement;
use app\models\BadgeBalance;
use app\models\BadgeCategory;
use app\models\BadgeGroup;
use app\models\ScalePointsBalance;
use app\models\Badge;
use app\models\Quest;
use app\models\QuestPendingTask;
use app\models\Goal;
use app\models\GoalSubtask;
use app\models\Follower;
use app\models\Notification;
use Yii;

class PersonalController extends \yii\web\Controller
{
    var $layout = 'medalist_inner';

    //todo - protect from unuthorized

    public function actionAchievements()
    {
        $achievements = Achievement::find()->where('user_id = '.Yii::$app->user->identity->id)->orderBy([ 'date_created' => SORT_DESC])->all();
        return $this->render('achievements', ['achievements' =>$achievements]);
    }
    public function actionAchievementAdd()
    {

        $questPendingTasks = QuestPendingTask::find()->where('user_id = '.Yii::$app->user->identity->id.' AND status = 0')->all();
        $goals = Goal::find()->where('user_id = '.Yii::$app->user->identity->id.' AND completed = 0')->all();

        $quest = false;
        $quest_id = !empty(Yii::$app->request->get()['quest_id']) ?  Yii::$app->request->get()['quest_id'] : 0;


        $goal = false;
        $goal_id = !empty(Yii::$app->request->get()['goal_id']) ?  Yii::$app->request->get()['goal_id'] : 0;



        $predefinedTitle = "";
        $predefinedText = "";
        if( !empty(Yii::$app->request->get()['quest_id']) ){
            $quest = Quest::findOne( Yii::$app->request->get()['quest_id'] );
            $predefinedTitle ="Выполнен квест ".$quest->name;
            $predefinedText ="Вы выполнили квест ".$quest->name.". Опишите как это было? Сложно или не очень? Что запомнилось?";
            $difficult = true;
        }
        if( !empty(Yii::$app->request->get()['goal_id']) ){
            $goal = Goal::findOne( Yii::$app->request->get()['goal_id'] );
            $predefinedTitle ="Выполна цель ".$goal->name;
            $predefinedText ="Вы выполнили цель ".$goal->name.". Опишите как это было? Сложно или не очень? Глядя на вас, другие смогут стать лучше.";
            $difficult = true;
        }

        $difficult = (!empty($goal_id) || !empty($quest_id));
        

        return $this->render('achievement-add', [
            'goals' => $goals, 
            'questPendingTasks' => $questPendingTasks,
            'quest' => $quest,
            'quest_id' => $quest_id,
            'goal' => $goal,
            'goal_id' => $goal_id,
            'difficult' => $difficult,

            'predefinedTitle' => $predefinedTitle,
            'predefinedText' => $predefinedText,
        ]);
    }

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }




    public function actionFriends()
    {

        //Кто уже в друзьях
        $followed = Follower::find()->where(['user_id' => Yii::$app->user->identity->id])->all();

        $excluded = [];
        foreach ($followed as $follower) {
            $excluded[] = $follower->to_user_id;
        }
        $excluded[] = Yii::$app->user->identity->id;

        $possibleFriends = Follower::findAlikeUsers( Yii::$app->user->identity->id )->where(['NOT IN', 'id', $excluded])->all();

        return $this->render('friends', [ 'possibleFriends' => $possibleFriends, 'followed' => $followed ]);
    }





    public function actionGoals()
    {
        //$id = Yii::$app->request->get()['goal_id'];
        $goals = Goal::find()->where(['user_id' => Yii::$app->user->identity->id ])->all();
        return $this->render('goals', ['goals' => $goals]);
    }

    public function actionGoal()
    {

        $id = Yii::$app->request->get()['goal_id'];
        $goal = Goal::findOne( $id );
        return $this->render('goal-detail', ['goal' => $goal]);
    }


    public function actionGoalAdd()
    {

        $questPendingTasks = QuestPendingTask::find()->where('user_id = '.Yii::$app->user->identity->id.' AND status = 0')->all();
        $goals = Goal::find()->where('user_id = '.Yii::$app->user->identity->id.' AND completed = 0')->all();

        $quest = false;
        $quest_id = !empty(Yii::$app->request->get()['quest_id']) ?  Yii::$app->request->get()['quest_id'] : 0;


        $goal = false;
        $goal_id = !empty(Yii::$app->request->get()['goal_id']) ?  Yii::$app->request->get()['goal_id'] : 0;



        $predefinedTitle = "";
        $predefinedText = "";
        if( !empty(Yii::$app->request->get()['quest_id']) ){
            $quest = Quest::findOne( Yii::$app->request->get()['quest_id'] );
            $predefinedTitle ="Выполнен квест ".$quest->name;
            $predefinedText ="Вы выполнили квест ".$quest->name.". Опишите как это было? Сложно или не очень? Что запомнилось?";
            $difficult = true;
        }

        $difficult = (!empty($goal_id) || !empty($quest_id));
        

        return $this->render('goal-add', [
            'goals' => $goals, 
            'questPendingTasks' => $questPendingTasks,
            'quest' => $quest,
            'quest_id' => $quest_id,
            'goal' => $goal,
            'goal_id' => $goal_id,
            'difficult' => $difficult,

            'predefinedTitle' => $predefinedTitle,
            'predefinedText' => $predefinedText,
        ]);
    }








    public function actionNews()
    {

        $news = Notification::getUserFeed ( Yii::$app->user->identity->id )->all();

        return $this->render('news', ['news' => $news]);
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
