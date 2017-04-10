<?php

namespace app\controllers;


use app\models\BadgeBalance;
use app\models\BadgeCategory;
use app\models\BadgeGroup;
use app\models\ScalePointsBalance;
use app\models\Badge;
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
        return $this->render('goals');
    }

    public function actionNews()
    {
        return $this->render('news');
    }

    public function actionQuests()
    {
        return $this->render('quests');
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

    public function actionSettings()
    {
        return $this->render('settings');
    }

}
