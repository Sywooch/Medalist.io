<?php

namespace app\controllers;
use app\models\Alarm;
use app\models\EmailTemplate;
use amnah\yii2\user\models\User;
use yii\db\Expression;
use Yii;

/*
CREATE TABLE `medalyst_yii`.`email_template` ( `email_template_id` INT(11) NOT NULL AUTO_INCREMENT , `code` VARCHAR(255) NOT NULL , `email_from` VARCHAR(1024) NULL , `email_to` VARCHAR(1024) NULL , `cc` VARCHAR(1024) NULL , `bcc` VARCHAR(1024) NULL , `html` TEXT NULL , `text` TEXT NULL , `extra_headers` TEXT NULL , PRIMARY KEY (`email_template_id`)) ENGINE = InnoDB;

ALTER TABLE `email_template` ADD `name_from` VARCHAR(1024) NULL AFTER `email_from`;
ALTER TABLE `email_template` ADD `files` TEXT NULL COMMENT 'json with urls' AFTER `extra_headers`;
ALTER TABLE `alarm` ADD `email_notified` INT(3) NULL DEFAULT '0' COMMENT 'how many imes alarm was notified' AFTER `traced`;
ALTER TABLE `alarm` ADD `last_email_notifiaction` DATETIME NULL AFTER `email_notified`;




INSERT INTO `email_template` (`email_template_id`, `code`, `email_from`, `name_from`, `email_to`, `cc`, `bcc`, `html`, `text`, `extra_headers`, `files`) VALUES (NULL, 'ALARM_NOTIFICATION', 'alarm@medalyst.online', NULL, NULL, NULL, NULL, '
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
     <title>Medalyst.online email template</title>


  </head>

  <body>
      <table style="width: 600px;" cellspacing="0" align="center">

          <tr style="background-color:  #8a44ff; height: 80px;">
              <td style="width: 450px; padding: 15px;">
                  <a href="http://medalyst.online/"><img src="http://medalyst.online/template/img/logo-white.png" alt=""></a>
              </td>
              <td  style="width: 150px; padding: 15px;">
              <!--http://www.flaticon.com/free-icon/vk-social-network-logo_25684#term=vk&page=1&position=3-->
                  <a href=""><img src="http://medalyst.online/template/img/icon-vk.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-fb.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-inst.png" style="max-width: 25px"></a>
              </td>
          </tr>

          <tr>
              <td colspan="2" style="padding: 25px;">
                  #CONTENT#
              </td>
          </tr>

          <tr style="background-color:  #FAFAFA;  height: 100px; padding: 15px;">
                <td style="font-size: 12px; color: #999; padding: 15px;">
                    Вы получили это письмо так как зарегистрированы в сервисе Medalyst.online. Перейдите по <a href="№">этой ссылке</a>, чтобы больше не получать писем.
                </td>
              <td  style="width: 150px;  padding: 15px;">
                  <a href=""><img src="http://medalyst.online/template/img/icon-vk-black.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-fb-black.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-inst-black.png" style="max-width: 25px"></a>
              </td>
          </tr>
      </table>
 

 
  </body>
</html>
', NULL, NULL, NULL);



INSERT INTO `email_template` (`email_template_id`, `code`, `email_from`, `name_from`, `email_to`, `cc`, `bcc`, `html`, `text`, `extra_headers`, `files`) VALUES (NULL, 'NEW_QUEST_CHALLENGE', 'no-reply@medalyst.online', NULL, NULL, NULL, NULL, '
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
     <title>Medalyst.online email template</title>


  </head>

  <body>
      <table style="width: 600px;" cellspacing="0" align="center">

          <tr style="background-color:  #8a44ff; height: 80px;">
              <td style="width: 450px; padding: 15px;">
                  <a href="http://medalyst.online/"><img src="http://medalyst.online/template/img/logo-white.png" alt=""></a>
              </td>
              <td  style="width: 150px; padding: 15px;">
              <!--http://www.flaticon.com/free-icon/vk-social-network-logo_25684#term=vk&page=1&position=3-->
                  <a href=""><img src="http://medalyst.online/template/img/icon-vk.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-fb.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-inst.png" style="max-width: 25px"></a>
              </td>
          </tr>

          <tr>
              <td colspan="2" style="padding: 25px;">
                  <h2 style="font-family: sans-serif;">Вам брошен новый вызов!</h2>
                  <p>#TO_NAME#, вам брошен новый вызов! #FROM_NAME# хочет, чтобы вы прошли испытание</p>
                  <div style="background-color:  #8a44ff; padding: 10px"><a href="#QUEST_URL#" style="color: white">#QUEST_NAME#</a></div>
                  <div style="text-align: center; background-color: #DDD;"><a href="#QUEST_URL#"><img src="#QUEST_IMAGE_URL#" alt="" style="width: 100%"></a></div>
                  <div style="text-align: center; background-color: black; padding: 15px">
                    <a style="display: inline-block;background-color: red;color: white;padding: 10px 25px;border-radius: 25px;text-decoration: none;" href="#QUEST_LIST_URL#">Принять вызов или отказать</a>
                  </div>
              </td>
          </tr>

          <tr style="background-color:  #FAFAFA;  height: 100px; padding: 15px;">
                <td style="font-size: 12px; color: #999; padding: 15px;">
                    Вы получили это письмо так как зарегистрированы в сервисе Medalyst.online. Перейдите по <a href="№">этой ссылке</a>, чтобы больше не получать писем.
                </td>
              <td  style="width: 150px;  padding: 15px;">
                  <a href=""><img src="http://medalyst.online/template/img/icon-vk-black.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-fb-black.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-inst-black.png" style="max-width: 25px"></a>
              </td>
          </tr>
      </table>
 

 
  </body>
</html>
', NULL, NULL, NULL);

ALTER TABLE `email_template` ADD `subject` VARCHAR(1024) NULL AFTER `email_to`;




INSERT INTO `email_template` (`email_template_id`, `code`, `email_from`, `name_from`, `email_to`, `subject`, `cc`, `bcc`, `html`, `text`, `extra_headers`, `files`) VALUES (NULL, 'QUEST_DEADLINE_EXPIRED', 'no-reply@medalyst.online', NULL, NULL, 'Плохие новости. Вы не успели завершить квест.', NULL, NULL, '<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
     <title>Medalyst.online email template</title>


  </head>

  <body>
      <table style="width: 600px;" cellspacing="0" align="center">

          <tr style="background-color:  #8a44ff; height: 80px;">
              <td style="width: 450px; padding: 15px;">
                  <a href="http://medalyst.online/"><img src="http://medalyst.online/template/img/logo-white.png" alt=""></a>
              </td>
              <td  style="width: 150px; padding: 15px;">
              <!--http://www.flaticon.com/free-icon/vk-social-network-logo_25684#term=vk&page=1&position=3-->
                  <a href=""><img src="http://medalyst.online/template/img/icon-vk.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-fb.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-inst.png" style="max-width: 25px"></a>
              </td>
          </tr>

          <tr>
              <td colspan="2" style="padding: 25px;">
                  <h2 style="font-family: sans-serif;">Вы провалили дедлайн по квесту</h2>

                  <table>
                    <tr>
                      <td><div style="font-size: 150px;">:(</div></td>
                      <td><p>#TO_NAME#, к сожалению, вы не успели сдать квест <a href="#QUEST_URL#">#QUEST_NAME#</a> вовремя. Ну, что ж поделать. В следующий раз у вас выйдет. Штраф 20 баллов.</p></td>
                    </tr>
                  </table>
                  
                  
              </td>
          </tr>

          <tr style="background-color:  #FAFAFA;  height: 100px; padding: 15px;">
                <td style="font-size: 12px; color: #999; padding: 15px;">
                    Вы получили это письмо так как зарегистрированы в сервисе Medalyst.online. Перейдите по <a href="№">этой ссылке</a>, чтобы больше не получать писем.
                </td>
              <td  style="width: 150px;  padding: 15px;">
                  <a href=""><img src="http://medalyst.online/template/img/icon-vk-black.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-fb-black.png" style="max-width: 25px"></a>
                  <a href=""><img src="http://medalyst.online/template/img/icon-inst-black.png" style="max-width: 25px"></a>
              </td>
          </tr>
      </table>
 

 
  </body>
</html>
', NULL, NULL, NULL);


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
                        ->where(['traced' => 0, 'status' => 0, 'email_notified' => 0])
                        //->where(['traced' => 0, 'status' => 0 ])
                        ->andWhere( 'date_created < :date_created', [ ':date_created' => date("Y-m-d H:i:s", time()-60*60*6) ])
                        /*->andWhere( [ 'or', 
                            //['<', 'last_email_notifiaction',  date("Y-m-d H:i:s", time()-60*60*12)  ],
                            ['is', 'last_email_notifiaction', NULL]  //ONCE PER 12 HOURS
                            ]) */ //todo -once per 12 horas - dont wordk
                        ->all();

        //GroupByUsers
        $groupedNotifiers = [];
        foreach($notTraced as $nt){
            $groupedNotifiers[ $nt->to_user_id][] = $nt;
            $nt->email_notified = $nt->email_notified + 1;
            $nt->last_email_notifiaction = date("Y-m-d H:i:s");
            $nt->save();
        }

        //var_dump($groupedNotifiers);

        foreach ($groupedNotifiers as $user => $alarms) {
            $content = '<p>Давненько вы не заходили на medalyst.online! А за это время произошло много нового, например: </p>';

            $u = User::findOne( $user );

            ob_start();

            foreach ($alarms as $alarm) {
                Alarm::renderAlarmBlockHTML( $alarm, true);
            }

            $alarmsHTML = ob_get_clean();

            $alarmsHTML = str_replace('href="/', 'href="http://medalyst.online/', $alarmsHTML);

            $content .= $alarmsHTML;

            $email = EmailTemplate::findOne( EmailTemplate::ALARM_NOTIFICATION );
            $email->send( $u->email,  ['CONTENT' => $content] , 'Ого! Чего только не случилось, пока вас не было');

        }

    }

}
