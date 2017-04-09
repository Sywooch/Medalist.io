<?php

namespace app\controllers;


use app\models\BadgeBalance;
use app\models\Badge;

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
        return $this->render('rewards');
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }

}
