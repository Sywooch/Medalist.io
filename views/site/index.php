<?php

/* @var $this yii\web\View */
 
$this->title = 'Medalyst.online. Система хранения достижений, выполнения целей и формирования рейтингов.';
?>

<div id="videoDiv">
     <div id="videoBlock">
        <div id="videoCurtain"></div>
         <video preload="preload" id="video" autoplay="autoplay" loop="loop">
        <source src="/template/video/medalyst_bg_01.webm" type="video/webm"></source>
        <source src="/template/video/medalyst_bg_01.mp4" type="video/mp4"></source>
     </video>


     <div id="videoMessage" >
        <div  class="owl-carousel owl-theme" style="width: 1000px; height: 70%; text-align: center; margin: 0 auto;">


            <div class="item">
			 	 <h1>Добро пожаловать на Медалист.</h1>
			  	 <h2>Медалист - интеллектуальная система повышения мотивации.</h2>
                 <h3>Позволяет ставить цели и достигать их, хранить личные достижения, выполнять квесты и бросать вызов другим.</h3>
             </div>


            <div class="item">
			 	 <h1>Существование - это не для тебя.</h1>
			  	 <h2>Ты знаешь закон достижения целей и вкус побед.</h2>
                 <h3>Тебе есть чем гордиться, как и многим из нас. Добавь свои достижения на доску почёта.</h3>
             </div>
            <div class="item">
                 <h1>Раздели радость своих побед с другими.</h1>
                 <h2>Поддержи своих друзей в борьбе,</h2>
                 <h3> и они разделят с тобой радость своих достижений.</h3>
            </div>
            <div class="item">
                 <h1>Тебе есть о чем рассказать?</h1>
                 <h2>Есть чем гордиться? Тебя есть за что уважать?</h2>
                 <h3>Заходи к нам и поделись своими достижениями со всеми. А если нет, тем более заходи, а то жизнь так скучно и пройдёт.</h3>
            </div>
            <div class="item">
                 <h1>Ты хочешь достигнуть своих целей?</h1>
                 <h2>Пора начинать действовать.</h2>
                 <h3>Мы способны на грандиозные достижения. Ты один из нас? Действуй, стремись к успеху, достигни своих целей. У многих уже получилось . Оставь бесполезные мечты, пора действовать.</h3>
             </div>
            <div class="item">
                 <h1>Самые выдающиеся люди</h1>
                 <h2>добились грандиозных результатов</h2>
                 <h3>лишь потому, что они действовали. Они были такими же как все, и лишь действие сделало их результат возможным.</h3>
             </div>
            <div class="item">
                 <h1>Ты способен на многое.</h1>
                 <h2>Пройди простые, но увлекательные квесты.</h2>
                 <h3>Ноаая игрушка? Нет, хорошо забытая старая - это реальная жизнь. Испытай себя.</h3>
             </div>
            <div class="item">
                 <h1>Изменить свою жизнь можно в любой момент.</h1>
                 <h2>Не знаешь как? Боишься трудностей?.</h2>
                 <h3>Напрасно, только пройдя через них можно чего-то добиться в жизни.</h3>
             </div>
            <div class="item">
                 <h1>Что такое развлечение?</h1>
                 <h2>Бесполезное проведение времени или то, от чего получаешь удовольствие?</h2>
                 <h3>Развлекись и проведи время с пользой, стань лидером и получи награды.</h3>
             </div>
            <div class="item">
                 <h1>Нет времени на игры?</h1>
                 <h2>Занимаешься спортом, бизнесом или саморазвитием?</h2>
                 <h3>Сохрани свои достижения в Медалисте. Ведь ты способен на многое.</h3>
             </div>
            <div class="item">
                 <h1>Успех – это сумма маленьких достижений,</h1>
                 <h2>повторяющихся день изо дня.</h2>
                 <h3 style="text-align:right;">Рудольф Коллер</h3>
             </div>
            <div class="item">
                 <h1>Достигай успеха</h1>
                 <h2>...каждый день</h2>
                 <h3>Medalyst - сервис контроля достижений</h3>
             </div>

         </div>

                 <p class="videoClick" >
                 <a href="<?=Yii::$app->urlManager->createUrl(['user/register' ])?>" class="mdlst-button mdlst-button-accent-main">Регистрируйся</a>
                 </p>

     </div>
      
 </div>


 <style>
#videoDiv {width: 100%; height: 450px; position: relative; overflow: hidden; margin-top: -35px;}
#videoCurtain { position: absolute; background-color: black; opacity: 0.4; width: 100%; height:  100%; left: 0; top: 0; }
#video {width: 100%;  }
#videoBlock,#videoMessage {width: 100%; height: 450px; position: absolute; top: 0; left: 0;}
/*#videoMessage *{padding:0.4em; margin:0;}*/
#videoMessage {text-shadow: 2px 2px 2px #000000; color:white;z-index:99;  padding-top: 50px ; margin:0;}
#videoMessage h1{font-size: 2.8em;color:#ffffff;text-align:center;}
#videoMessage h2{font-size: 2.3em;color:#ffffff;text-align:center;}
#videoMessage h3{font-size: 1.8em;color:#ffffff;text-align:center;}
.videoClick {text-align:center}
.videoClick a{color:white; font-size: 1.7em; text-shadow: none; cursor:pointer;cursor:hand; padding: 12px 35px !important;}
</style>
