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
use app\models\Alarm;
use amnah\yii2\user\models\User;
use yii\db\Expression;
use Yii;

class PersonalController extends \yii\web\Controller
{
    var $layout = 'medalist_inner';

    //todo - protect from unuthorized

    public function actionDevelopment()
    {


        
        if( !Yii::$app->user->isGuest ){
            $userToFind = Yii::$app->user->identity->id;
            $scalePointsBalance = ScalePointsBalance::find()->where('user_id = '.$userToFind)->orderBy([ 'date_created' => SORT_DESC ])->all();
            return $this->render('development', ['scalePointsBalance' =>$scalePointsBalance  ]);    
        }else{
           // throw new \yii\web\NotFoundHttpException();
            throw new \yii\web\ForbiddenHttpException();
             return false;
        }

        
    }
    //todo - protect from unuthorized

    public function actionAchievements()
    {


        $other = false;

        if( !Yii::$app->user->isGuest ){
            $userToFind = Yii::$app->user->identity->id;

        }
        
	        if( !empty(Yii::$app->request->get()['user_id']) ){

	            $userToFind = Yii::$app->request->get()['user_id'];


		        if( Yii::$app->user->isGuest ){
            		$other = true;

				}
				elseif($userToFind != Yii::$app->user->identity->id){
            		$other = true;
				}
	
	        }


        if( !Yii::$app->user->isGuest ){

			if(Yii::$app->user->identity->id == 17) {
				$other = false;
			}
		}


        $achievements = Achievement::find()->where('user_id = '.$userToFind)->orderBy([ 'date_achieved' => SORT_DESC, 'date_created' => SORT_DESC ])->all();
        return $this->render('achievements', ['achievements' =>$achievements,  'other' =>  $other?$userToFind:false ]);
    }


    public function actionAchievement()
    {
        $achievement = Achievement::findOne(Yii::$app->request->get()['achievement_id']);

        $other = true;

        if( !Yii::$app->user->isGuest ){
            if( Yii::$app->user->identity->id == $achievement->user_id ){
                $other = false;
            }

        }else{
             $other = true;
        }

        if( !Yii::$app->user->isGuest ){
			if(Yii::$app->user->identity->id == 17) {
				$other = false;
			}
        }

     

        if( ! $achievement ){
             throw new \yii\web\NotFoundHttpException();
             return false;
        }

        $quest = !empty($achievement->quest_id) ? Quest::findOne( $achievement->quest_id ) : false;
        $goal = !empty($achievement->goal_id) ? Goal::findOne( $achievement->goal_id ) : false;


         //OG PARAMS
        $this->view->params['og_title'] = $achievement->getUser()->name.': Достижение: '.$achievement->name;
        $this->view->params['og_description'] = Yii::$app->decor->cutDescription($achievement->description, 700);

      	$photos = $achievement->getPhotos();
   	    if(!empty($photos) ) { 
			$thumbs = Yii::$app->decor->getThumbnails($photos);

	        $this->view->params['og_image'] = 'http://'.Yii::$app->request->serverName.$photos[0]->filename;
		}

        return $this->render('achievement', [
            'achievement' =>$achievement,
            'quest' => $quest,
            'goal' => $goal,
		    'other' =>  $other
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
            $predefinedTitle ="Выполнена цель ".$goal->name;
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

    public function actionAchievementEdit()
    {

        $achievement =  Achievement::findOne ( Yii::$app->request->get()['achievement_id'] );

        $questPendingTasks = QuestPendingTask::find()->where('user_id = '.$achievement->user_id/*.' AND status = 0'*/)->all();
        $goals = Goal::find()->where('user_id = '.$achievement->user_id/*.' AND completed = 0'*/)->all();

/*
        $quest = false;
        $quest_id = !empty(Yii::$app->request->get()['quest_id']) ?  Yii::$app->request->get()['quest_id'] : 0;

        $goal = false;
        $goal_id = !empty(Yii::$app->request->get()['goal_id']) ?  Yii::$app->request->get()['goal_id'] : 0;
*/
 
        $quest_id = $achievement->quest_id;
        $goal_id = $achievement->goal_id;
        $quest = false;
        $goal = false;

        return $this->render('achievement-edit', [
            'goals' => $goals, 
            'questPendingTasks' => $questPendingTasks,
            'quest' => $quest,
            'quest_id' => $quest_id,
            'goal' => $goal,
            'goal_id' => $goal_id,
            'difficult' => $achievement->difficult,
            'difficulty' => $achievement->difficulty,
            'achievement' => $achievement,
            

            'predefinedTitle' => $achievement->name,
            'predefinedText' => $achievement->description
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

        $possibleFriends = Follower::findAlikeUsers( Yii::$app->user->identity->id )->where(['NOT IN', 'id', $excluded])->andWhere(['status' => '1'])->all();

        return $this->render('friends', [ 'possibleFriends' => $possibleFriends, 'followed' => $followed ]);
    }




    public function actionAlarms()
    {

        //Кто уже в друзьях
        $alarms = Alarm::find()->where(['to_user_id' => Yii::$app->user->identity->id])->orderBy(['date_created' => SORT_DESC])->all();

        

        return $this->render('alarms', [ 'alarms' => $alarms  ]);
    }





    public function actionViewprofile()
    {

        // OG  PARAMS


        $post = Yii::$app->request->post();

        $passwordChanged = false;

        //CURRENT USER CHANGE FORM
        if( !empty($post)  && !Yii::$app->user->isGuest ){
            $currentUser = User::findOne( Yii::$app->user->identity->id );
           // var_dump( $_FILES );
            if( !empty($_FILES['image']['tmp_name']) ){
                $srcTmp = $_FILES['image']['tmp_name'];
                $info = pathinfo( $_FILES['image']['name'] );

				$targetFile = './uploads/u/'.$currentUser->id.".".strtolower($info['extension']);
                move_uploaded_file($srcTmp,$targetFile);

				$newFilename_tb = './uploads/u/'.$currentUser->id."_tb.".strtolower($info['extension']);
				Yii::$app->decor->createThumbnail($targetFile, $newFilename_tb, 160, 190);
                
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

            if( !empty( $post['password'] ) ){
                
                if( $post['password'] == $post['password_confirm']){
                    $currentUser->setPassword(  $post['password'] );
                    
                    $currentUser->save();    
                    $passwordChanged = true;
                }
                
            }
           // if( !empty($_FILES['image']))
        }



        //Кто уже в друзьях
        if( !empty(Yii::$app->request->get()['user_id'] )) {
            $user = User::findOne( Yii::$app->request->get()['user_id']  );

            if ( ! $user ){
                throw new \yii\web\NotFoundHttpException();
            }
        }

        $isFollowed = false;

         //Кто уже в друзьях
        $followed = [];
        $possibleFriends = [];

        if( !Yii::$app->user->isGuest ) {
            $followed = Follower::find()->where(['user_id' => Yii::$app->user->identity->id])->all();

            $excluded = [];
            foreach ($followed as $follower) {

                if ( !$isFollowed ) {
                    $isFollowed = $follower->to_user_id == $user->id;
                }
                $excluded[] = $follower->to_user_id;

            }
            $excluded[] = Yii::$app->user->identity->id;

            $possibleFriends = Follower::findAlikeUsers( Yii::$app->user->identity->id )->where(['NOT IN', 'id', $excluded])->andWhere(['status' => '1'])->all();

        }

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


         $news = Notification::find()->where('user_id = '.$user->id)->orderBy(['date_created' => SORT_DESC])->all();



         //OG PARAMS
        $this->view->params['og_title'] = $user->name.': достижения, цели и стремления ';
        $this->view->params['og_description'] = 'Узнайте достижения '.$user->name.', бросьте ему вызов!';
        $this->view->params['og_image'] = 'http://'.Yii::$app->request->serverName.$user->getProfile()->one()->getAvatarSrc();


        return $this->render('profileview', [ 
            'user' => $user,  
            'interests' => $interests,  
            'possibleFriends' => $possibleFriends, 
            'followed' => $followed,
            'scaleBalance' => $scaleBalance,
            'scales' => $scales,
            'news' => $news,
            'totalBalance' => $totalBalance,
            'isFollowed' => $isFollowed,
            'passwordChanged' => $passwordChanged
         ]);
    }





    public function actionGoals()
    {
        //$id = Yii::$app->request->get()['goal_id'];

/*
        $userToFind = Yii::$app->user->identity->id;

        $other = false;

        if( !empty(Yii::$app->request->get()['user_id']) ){
            $other = true;
            $userToFind = Yii::$app->request->get()['user_id'];
        }

        if( !Yii::$app->user->isGuest ){
			if(Yii::$app->user->identity->id == 17) {
				$other = false;
			}
        }

*/


        $other = false;

        if( !Yii::$app->user->isGuest ){
            $userToFind = Yii::$app->user->identity->id;

        }
        
	        if( !empty(Yii::$app->request->get()['user_id']) ){

	            $userToFind = Yii::$app->request->get()['user_id'];


		        if( Yii::$app->user->isGuest ){
            		$other = true;

				}
				elseif($userToFind != Yii::$app->user->identity->id){
            		$other = true;
				}
	
	        }


        if( !Yii::$app->user->isGuest ){

			if(Yii::$app->user->identity->id == 17) {
				$other = false;
			}
		}



        $goals = Goal::find()->where('user_id = '.$userToFind)->orderBy(['goal_id' => SORT_DESC])->all();
        return $this->render('goals', ['goals' => $goals,  'other' =>  $other?$userToFind:false ]);
    }

    public function actionGoal()
    {

        $id = Yii::$app->request->get()['goal_id'];
        $goal = Goal::findOne( $id );
        if( !$goal ){
             throw new \yii\web\NotFoundHttpException();
        }



        $other = true;

        if( !Yii::$app->user->isGuest ){
            if( Yii::$app->user->identity->id == $goal->user_id ){
                $other = false;
            }

        }else{
             $other = true;
        }

        if( !Yii::$app->user->isGuest ){
			if(Yii::$app->user->identity->id == 17) {
				$other = false;
			}
        }


         //OG PARAMS
        $this->view->params['og_title'] = $goal->getUser()->name.': Цель: '.$goal->name;
        $this->view->params['og_description'] = $goal->description;

      	$photos = $goal->getPhotos();
   	    if(!empty($photos) ) { 
/*			$thumbs = Yii::$app->decor->getThumbnails($photos);*/

	        $this->view->params['og_image'] = 'http://'.Yii::$app->request->serverName.$photos[0]->filename;
		}



        return $this->render('goal-detail', ['goal' => $goal, 'other' => $other]);
    }


    public function actionGoalAdd()
    {

        $predefinedTitle = "";
        $predefinedText = "";
    

        $difficult = (!empty($goal_id) || !empty($quest_id));
        

        return $this->render('goal-add', [
           
            'difficult' => $difficult,

            'predefinedTitle' => $predefinedTitle,
            'predefinedText' => $predefinedText,
        ]);
    }





    public function actionGoalUpdate()
    {

        $goal_id = Yii::$app->request->get()['goal_id'];

		if(Yii::$app->user->identity->id == 17){
	        $goal = Goal::find()->where(['goal_id' => $goal_id])->one();
		}
		else{
	        $goal = Goal::find()->where(['goal_id' => $goal_id, 'user_id' => Yii::$app->user->identity->id])->one();
		}

         if( !$goal ){
             throw new \yii\web\ForbiddenHttpException();
             return false;
        }

        $predefinedTitle = $goal->name;
        $predefinedText = $goal->description;
       
        $private =  $goal->private;
        

        return $this->render('goal-update', [
        
        
            'private' => $private,
            'goal' => $goal,

            'predefinedTitle' => $predefinedTitle,
            'predefinedText' => $predefinedText,
        ]);
    }








    public function actionNews()
    {

        $news = Notification::getUserFeed ( Yii::$app->user->identity->id, false, false )->orderBy(['date_created' => SORT_DESC])->all();

        return $this->render('news', ['news' => $news]);
    }

    public function actionQuests()
    {

        //Todo подбор интересных квестов

        $questChallenges = QuestChallenge::find()->where('to_user_id = '.Yii::$app->user->identity->id.' AND status = 0')->all();
        $questChallengesCreated = QuestChallenge::find()->where('user_id = '.Yii::$app->user->identity->id.' ')->all();



        $questPendingTasks = QuestPendingTask::find()->where('user_id = '.Yii::$app->user->identity->id.' AND status = 0')->all();
        $excludeIds = [];
        foreach($questPendingTasks as $pt ){
            $excludeIds[] = $pt->quest_id;
        }

        $quests = Quest::find()->where(['not in', 'quest_id', $excludeIds])->andWhere(['active' => 1, 'deleted' => 0]);


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
            'questChallenges' => $questChallenges, 
            'questChallengesCreated' => $questChallengesCreated, 
            'cats' => $cats, 
            'category_selected' => $category_selected,
            'predefinedText' => $predefinedText,
        ]);
    }








    public function actionQuest()
    {

        $get = Yii::$app->request->get();

        $q = Quest::findOne($get['quest_id']);


        if( !$q ){
             throw new \yii\web\NotFoundHttpException();
             return false;
        }

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


         

         //OG PARAMS
        $this->view->params['og_title'] = 'Квест '.$q->name." - пройди и получи баллы. Сможешь?";
        $this->view->params['og_description'] = 'А вы сможете выполнить квест '.$q->name.'? Кое-кто уже доказал, что сможет.';
        $this->view->params['og_image'] = 'http://'.Yii::$app->request->serverName.'/'.$q->picture;


        return $this->render('quest', ['quest' => $q, 'category' => $category , 'badge' => $badge , 'achievements' => $achievements]);
    }




    public function actionQuestChallenge()
    {

        $get = Yii::$app->request->get();

        $q = Quest::findOne($get['quest_id']);

        if( !$q ){
             throw new \yii\web\NotFoundHttpException();
             return false;
        }


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


          //Кто уже в друзьях
        $followed = Follower::find()->where(['user_id' => Yii::$app->user->identity->id])->all();

         
        return $this->render('quest-challenge', [
            'quest' => $q, 
            'category' => $category , 
            'badge' => $badge , 
            'achievements' => $achievements,
            'followed' => $followed,
        ]);
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

    public function actionMyRewards()
    {
        if( !empty(Yii::$app->request->get()['user_id'])) {
            $user_id = Yii::$app->request->get()['user_id'];
            $user = User::findOne($user_id);

            $badgeBalance = BadgeBalance::find()->where('user_id = '.$user_id)->all();
            $badges = [];
            foreach( $badgeBalance as $bb ){
                $badges[] = $bb;

            }

            $badgeGroups = BadgeGroup::find()->all();
            $badgeTotal = Badge::find()->all();

            return $this->render('my-rewards', ['badges' => $badges, 'badgeGroups' => $badgeGroups, 'badgeTotal' => $badgeTotal, 'user' => $user]);    
        }else{
            $this->redirect(['site/index']);
        }

        
    }

    

    public function actionRewardDetail()
    {

        $get = Yii::$app->request->get();

        $badge = Badge::findOne( $get['badge_id'] );

        if( ! $badge ){
             throw new \yii\web\NotFoundHttpException();
             return false;
        }

        $badgeBalance = false;

        if( !empty($get['badge_balance_id']) ){
            $badgeBalance = BadgeBalance::findOne( $get['badge_balance_id'] );
        }


         //OG PARAMS
        $this->view->params['og_title'] = 'Награда '.$badge->name."! Узнай, как получить.";
        $this->view->params['og_description'] = 'Выполняй квесты medalyst.online  и получай награды! Например, '.$badge->picture.'.';
        $this->view->params['og_image'] = 'http://'.Yii::$app->request->serverName.$badge->picture;
        

        return $this->render('reward-detail', ['badge' => $badge, 'badgeBalance' => $badgeBalance]);
    }





    public function actionSettings()
    {
        return $this->render('settings');
    }


    public function actionFriendsFind()
    {

       $post = Yii::$app->request->post();
       $predefinedText = "";
       if( !empty($post['text'])){
            $predefinedText = $post['text'];
			$users = User::findUsers($post['text']);
        }
		else{
	        $users = User::find();

	   	    $users = $users->limit(10);
        	$users = $users->orderBy(new Expression('rand()'));
	        $users = $users->all();


		}

        return $this->render('friends-find', [ 'users' => $users, 'predefinedText' => $predefinedText]);

    }



}
