<?php

namespace app\controllers;

class AlarmController extends \yii\web\Controller
{
    public function actionAjaxAlarmChecknew()
    {
        return $this->render('ajax-alarm-checknew');
    }

    public function actionAjaxAlarmSetViewed()
    {
        return $this->render('ajax-alarm-set-viewed');
    }

}
