<?php

namespace app\controllers;
use app\models\Alarm;
use amnah\yii2\user\models\User;
use yii\db\Expression;
use Yii;

/*
CREATE TABLE `medalyst_yii`.`email_template` ( `email_template_id` INT(11) NOT NULL AUTO_INCREMENT , `code` VARCHAR(255) NOT NULL , `email_from` VARCHAR(1024) NULL , `email_to` VARCHAR(1024) NULL , `cc` VARCHAR(1024) NULL , `bcc` VARCHAR(1024) NULL , `html` TEXT NULL , `text` TEXT NULL , `extra_headers` TEXT NULL , PRIMARY KEY (`email_template_id`)) ENGINE = InnoDB;

ALTER TABLE `email_template` ADD `name_from` VARCHAR(1024) NULL AFTER `email_from`;
ALTER TABLE `email_template` ADD `files` TEXT NULL COMMENT 'json with urls' AFTER `extra_headers`;
ALTER TABLE `alarm` ADD `email_notified` INT(3) NULL DEFAULT '0' COMMENT 'how many imes alarm was notified' AFTER `traced`;
ALTER TABLE `alarm` ADD `last_email_notifiaction` DATETIME NULL AFTER `email_notified`;

*/
class AlarmController extends \yii\web\Controller
{
    public function actionAjaxAlarmCheckNew()
    {
 
    	if( Yii::$app->user->isGuest ){
    		return '';
    	}

		$big = !empty(Yii::$app->request->get()['big']) ;
    	 
    	$alarms = Alarm::find()->where(['to_user_id' => Yii::$app->user->identity->id, 'traced' => 0])->orderBy(['date_created' => SORT_DESC, 'traced' => SORT_ASC])->limit(5)->all();

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


    public function actionCronCheckNotTracedAlarms(){

        //6 horas
        $notTraced = Alarm::find()
                        ->where(['traced' => 0, 'status' => 0])
                        ->andWhere( 'date_created < :date_created', [ ':date_created' => date("Y-m-d H:i:s", time()-60*60*6) ])
                        ->andWhere( [ 'or', 
                            //['<', 'last_email_notifiaction',  date("Y-m-d H:i:s", time()-60*60*12)  ],
                            ['is', 'last_email_notifiaction', NULL]  //ONCE PER 12 HOURS
                            ]) 
                        ->all();

        //GroupByUsers
        $groupedNotifiers = [];
        foreach($notTraced as $nt){
            $groupedNotifiers[ $nt->to_user_id][] = $nt;
            $nt->email_notified = $nt->email_notified + 1;
            $nt->last_email_notifiaction = date("Y-m-d H:i:s");
            //$nt->save();
        }

        var_dump($groupedNotifiers);

    }

}
