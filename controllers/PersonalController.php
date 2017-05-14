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
use app\models\Interest;
use app\models\Scale;
use app\models\Category;
use app\models\Photo;
use amnah\yii2\user\models\User;
use yii\db\Expression;
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
    public function actionAchievement()
    {
        $achievement = Achievement::findOne(Yii::$app->request->get()['achievement_id']);

        $quest = false;
        $goal = false;

        return $this->render('achievement', [
            'achievement' =>$achievement,
            'quest' => $quest,
            'goal' => $goal
        ]);
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





    public function actionViewprofile()
    {


        $post = Yii::$app->request->post();

        if( !empty($post)  && !Yii::$app->user->isGuest ){
            $currentUser = User::findOne( Yii::$app->user->identity->id );
           // var_dump( $_FILES );
            if( !empty($_FILES['image']['tmp_name']) ){
                $srcTmp = $_FILES['image']['tmp_name'];
                $info = pathinfo( $_FILES['image']['name'] );
                move_uploaded_file($srcTmp,'./uploads/u/'.$currentUser->id.".".$info['extension']);
                
                //$photo = new Photo;
                $photo = Photo::find()->where(['entity_id' => Yii::$app->user->identity->id, 'entity_class' => 'User'  ])->one();
                if( !$photo ){
                    $photo = new Photo;
                    $photo->entity_id =  Yii::$app->user->identity->id;
                    $photo->entity_class = 'User';
                   
                }
                $photo->date_created = date("Y-m-d H:i:s");
                $photo->filename = '/uploads/u/'.$currentUser->id.".".$info['extension'];

                $photo->save();
            }

            if( !empty( $post['name'] ) ){
                $profile = $currentUser->getProfile()->one();

                $name = trim( $post['name'] );
                $profile->full_name = $name;
                $profile->save();
            }
           // if( !empty($_FILES['image']))
        }



        //Кто уже в друзьях
        if( !empty(Yii::$app->request->get()['user_id'] )) {
            $user = User::findOne( Yii::$app->request->get()['user_id']  );
        }

        $isFollowed = false;

         //Кто уже в друзьях
        $followed = Follower::find()->where(['user_id' => Yii::$app->user->identity->id])->all();

        $excluded = [];
        foreach ($followed as $follower) {

            if ( !$isFollowed ) {
                $isFollowed = $follower->to_user_id == $user->id;
            }
            $excluded[] = $follower->to_user_id;

        }
        $excluded[] = Yii::$app->user->identity->id;

        $possibleFriends = Follower::findAlikeUsers( Yii::$app->user->identity->id )->where(['NOT IN', 'id', $excluded])->all();



        $interests = Interest::getUserInterests( $user->id )->all() ;


        $scalePoints = ScalePointsBalance::find()->where(['user_id' => $user->id])->all();
        $scales = [];
        $scaleBalance = [];
        $totalBalance  = 0;
        foreach ($scalePoints as $spb) {
            $totalBalance += $spb->points;
            $scales[ $spb->scale_id ] = $spb->getScale();
            if( empty($scaleBalance[ $spb->scale_id ])) { $scaleBalance[ $spb->scale_id ] = 0;}
            $scaleBalance[ $spb->scale_id ] += $spb->points;
        }
        arsort($scaleBalance);


         $news = Notification::find()->where('user_id = '.$user->id)->all();



        return $this->render('profileview', [ 
            'user' => $user,  
            'interests' => $interests,  
            'possibleFriends' => $possibleFriends, 
            'followed' => $followed,
            'scaleBalance' => $scaleBalance,
            'scales' => $scales,
            'news' => $news,
            'totalBalance' => $totalBalance,
            'isFollowed' => $isFollowed
         ]);
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

        $quests = Quest::find()->where(['not in', 'quest_id', $excludeIds]);


        $quests = $quests->limit(10);
        $quests = $quests->orderBy(new Expression('rand()'));
        

        $post = Yii::$app->request->post();
        $category_selected = 0;
        $predefinedText = "";
        if( !empty($post['category_id'])){
            $category_selected = $post['category_id'];
            $quests = $quests->andWhere(['category_id' => $post['category_id']]);
             $quests = $quests->limit(false);
        }
       if( !empty($post['text'])){
            $predefinedText = $post['text'];
            $quests = $quests->andFilterWhere(['like', 'name', $post['text']]);
            $quests = $quests->limit(false);
        }/* */

        $quests = $quests->all();


        $cats = Category::find()->all();

        return $this->render('quests', [
            'quests' => $quests, 
            'questsPending' => $questPendingTasks, 
            'cats' => $cats, 
            'category_selected' => $category_selected,
            'predefinedText' => $predefinedText,
        ]);
    }








    public function actionQuest()
    {

        $get = Yii::$app->request->get();

        $q = Quest::findOne($get['quest_id']);


        $rewards = $q->getRewards()->all();

        $badge = false; 
        $benefits = [];
        foreach ($rewards as $rew ) {



            if( !empty($rew->badge_id ) ) {
                $badge = Badge::findOne( $rew->badge_id );
            }

            # code...
        }


        //Если есть шкала - юзаем ее, а если только награда - юзаем его

        if( !empty($rewards[0]->scale_id )){
     
            $scale = Scale::findOne( $rewards[0]->scale_id );
        }else{
         
            if( !empty($rewards[0]->badge_id ) ){
             
                $badge = Badge::findOne( $rewards[0]->badge_id );
                $badgeScalePoints = $badge->getBadgeScalePoints( );
                if( !empty($badgeScalePoints->scale_id)){
                 
                    $scale = Scale::findOne( $badgeScalePoints->scale_id );
                }
            }
        }

        

        if( !empty($q->category_id)){
            $category = Category::findOne( $q->category_id );
        }


        $achievements = $q->getAchievements();
        $tA = array();
        foreach ($achievements as $achievement) {
            $tA[ $achievement->user_id ] = $achievement;
        }
        $achievements = $tA;


         
        return $this->render('quest', ['quest' => $q, 'category' => $category , 'badge' => $badge , 'achievements' => $achievements]);
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
