<?php

namespace app\controllers;
use app\models\Alarm;
use amnah\yii2\user\models\User;
use yii\db\Expression;
use Yii;

class AlarmController extends \yii\web\Controller
{
    public function actionAjaxAlarmCheckNew()
    {
 
    	if( Yii::$app->user->isGuest ){
    		return '';
    	}

		$big = !empty(Yii::$app->request->get()['big']) ;
    	 
    	$alarms = Alarm::find()->where(['to_user_id' => Yii::$app->user->identity->id, 'traced' => 0])->orderBy(['date_created' => SORT_DESC])->limit(5)->all();

    	foreach ($alarms as $alarm) {
    		Alarm::renderAlarmBlockHTML($alarm, $big)	;
    		$alarm->traced = 1;

    		$alarm->save();
    	}

        
    }

    public function actionAjaxAlarmSetViewed()
    {
        return $this->render('ajax-alarm-set-viewed');
    }

}
