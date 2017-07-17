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



CREATE TABLE `medalyst_yii`.`email_trace` ( `email_trace_id` INT(11) NOT NULL AUTO_INCREMENT , `date_created` DATETIME NOT NULL , `user_id` INT(11) NOT NULL , `email` VARCHAR(255) NULL , `email_template_id` INT(11) NULL , `status` INT(1) NULL , `meta` VARCHAR(2048) NULL , `counter` INT(5) NULL , PRIMARY KEY (`email_trace_id`)) ENGINE = InnoDB;

ALTER TABLE `email_trace` CHANGE `user_id` `user_id` INT(11) NULL;




EMAIL_REANIMATE_1

INSERT INTO `email_template` (`email_template_id`, `code`, `email_from`, `name_from`, `email_to`, `subject`, `cc`, `bcc`, `html`, `text`, `extra_headers`, `files`) VALUES (NULL, 'EMAIL_REANIMATE_1', 'no-reply@medalyst.online', NULL, NULL, 'Мы не можем вас найти. Куда вы пропали?', NULL, NULL, '
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
                  <h2 style="font-family: sans-serif;">Вас давно не было!</h2>

                  <table>
                    <tr>
                      <td><img src="http://medalyst.online/template/img/e/lnch01_1.jpg" style="max-width: 100%"></td>
                    </tr>
                    <tr>
                      <td><p>#TO_NAME#, Вас почему-то давно не было на нашем сайте.</p></td>
                    </tr>
                    <tr>
                      <td><p>Самое трудное - это начать. Часто мы даём себе обещание, что "с понедельника" начнём новую жизнь. И часто в понедельник ничего не происходит.</p></td>
                    </tr>
                    <tr>
                      <td><p>С Медалистом новая жизнь начинается каждый день. Ещё одно достижение, ещё одна цель. Ещё один шанс стать чуточку лучше.</p></td>
                    </tr>
                    <tr>
                      <td><p>Продолжите свой путь к успеху прямо сейчас.</p></td>
                    </tr>
                    <tr>
                      <td><p>Поставьте себе новые цели; откройте новые горизонты.</p></td>
                    </tr>
                    <tr>
                      <td> <a style="display: inline-block;background-color: red;color: white;padding: 10px 25px;border-radius: 25px;text-decoration: none;" href="#ENTER_URL#">Вернуться на Medalyst.Online</a></td>
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






EMAIL_REANIMATE_2

INSERT INTO `email_template` (`email_template_id`, `code`, `email_from`, `name_from`, `email_to`, `subject`, `cc`, `bcc`, `html`, `text`, `extra_headers`, `files`) VALUES (NULL, 'EMAIL_REANIMATE_2', 'no-reply@medalyst.online', NULL, NULL, 'Уж неделя прошла... Столько нового произошло!', NULL, NULL, '
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
                  <h2 style="font-family: sans-serif;">Прошла целая неделя...</h2>

                  <table>
                    <tr>
                      <td><img src="http://medalyst.online/template/img/e/lnch02_1.jpg" style="max-width: 100%"></td>
                    </tr>
                    <tr>
                      <td><p>#TO_NAME#, последний раз вы заходили в свою учётку на medalist.online неделю назад.</p></td>
                    </tr>
                    <tr>
                      <td><p>За это время сотни людей отважились на новые цели, о которых до этого даже и подумать не могли. А многие - примут участие в захватывающих квестах, и им-то уж точно не будет стыдно за потраченный отпуск ;-)</p></td>
                    </tr> 
                    <tr>
                      <td><p>Чем же вы хуже? Самое время вернуться. Акутализируйте, пожалуйста, свои цели и задачи, и запишитесь на квест.</p></td>
                    </tr> 
                    <tr>
                      <td> <a style="display: inline-bloыck;background-color: red;color: white;padding: 10px 25px;border-radius: 25px;text-decoration: none;" href="#ENTER_URL#">Вернуться на Medalyst.Online</a></td>
                    </tr>


                    <tr>
                      <td><p>Пс!.. Если Вы вернётесь в течение суток после прочтения этого письма - вы получите секретную награду.</p></td>
                    </tr>  
                    <tr>
                      <td><p>[Данное письмо - сжечь после прочтения]</p></td>
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



EMAIL_REANIMATE_3

INSERT INTO `email_template` (`email_template_id`, `code`, `email_from`, `name_from`, `email_to`, `subject`, `cc`, `bcc`, `html`, `text`, `extra_headers`, `files`) VALUES (NULL, 'EMAIL_REANIMATE_3', 'no-reply@medalyst.online', NULL, NULL, 'Ваш аккаунт заблокирован.', NULL, NULL, '
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
                  <h2 style="font-family: sans-serif;">Ваш аккаунт заблокирован. Будет.</h2>

                  <table>
                    <tr>
                      <td><img src="http://medalyst.online/template/img/e/lnch03_1.jpg" style="max-width: 100%"></td>
                    </tr>
                    <tr>
                      <td><p>#TO_NAME#, прошло уже 2 недели с момента вашего последнего захода на medalyst.online.</p></td>
                    </tr> 
                    <tr>
                      <td><p>По какой-то причине вы не хотите продолжать вместе с нами. Чтобы не докучать вам письмами (это последнее честно-честно), завтра мы приостановим дейсвтие вашей учётной записи. Ваши достижения и цели будут скрыты с сайта, а их комментирование и подтверждение заблокировано.</p></td>
                    </tr> 
                    <tr>
                      <td><p>Вы можете отменить блокировку в любой момент, нажав кнопку ниже. Или просто авторизовавшись на медалисте =)</p></td>
                    </tr> 
                    <tr>
                      <td> <a style="display: inline-block;background-color: red;color: white;padding: 10px 25px;border-radius: 25px;text-decoration: none;" href="#ENTER_URL#">Вернуться на Medalyst.Online</a></td>
                    </tr>
 
                    <tr>
                      <td><p>Надеемся, Вы вернётесь! Ведь столько классных вещей ещё можно сделать, и столько возможностей сделать себя и мир лучше.</p></td>
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




CREATE TABLE `medalyst_yii`.`email_referral` ( `email_referral_id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL , `to_user_id` INT(11) NULL COMMENT 'is added AFTER registration' , `email` VARCHAR(512) NOT NULL , `date_created` DATETIME NOT NULL , PRIMARY KEY (`email_referral_id`)) ENGINE = InnoDB;


EMAIL_REFERRAL_INVITE


INSERT INTO `email_template` (`email_template_id`, `code`, `email_from`, `name_from`, `email_to`, `subject`, `cc`, `bcc`, `html`, `text`, `extra_headers`, `files`) VALUES (NULL, 'EMAIL_REFERRAL_INVITE', NULL, NULL, NULL, 'Ваш друг приглашает вас в Medalyst.online!', NULL, NULL, '
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
                  <h2 style="font-family: sans-serif;">Ваш друг приглашает вас в Medalyst.</h2>

                  <table>
                    
                    <tr>
                      <td><p>Ваш друг #FRIEND_NAME# приглашает вас отрыть новую страницу личных достижений и персонального роста.</p></td>
                    </tr> 
                    <tr>
                      <td><p>Сервис Медалист - это сотни квестов, система личных целей и достижений, тренды развития, возможность бросить вызов друзьям и ещё куча крутых штук.</p></td>
                    </tr>  
                    <tr>
                      <td> <a style="display: inline-block;background-color: red;color: white;padding: 10px 25px;border-radius: 25px;text-decoration: none;" href="#ENTER_URL#">Зарегистрироваться на Medalyst.Online</a></td>
                    </tr>
  

                  </table>
                  
                  
              </td>
          </tr>

          <tr style="background-color:  #FAFAFA;  height: 100px; padding: 15px;">
                <td style="font-size: 12px; color: #999; padding: 15px;">
                    Вы получили это письмо так как ваш друг указал ваш емейл в качестве контактного. Перейдите по <a href="№">этой ссылке</a>, чтобы больше не получать писем.
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

ALTER TABLE `email_referral` ADD `status` INT(2) NOT NULL DEFAULT '0' AFTER `date_created`, ADD `date_accepted` INT NULL AFTER `status`;




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
