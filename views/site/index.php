<?php

/* @var $this yii\web\View */
 
$this->title = 'My Yii Application';
?>
<div id="videoDiv">
     <div id="videoBlock">
        <div id="videoCurtain"></div>
         <video preload="preload" id="video" autoplay="autoplay" loop="loop">
        <source src="/template/video/medalyst_bg_01.webm" type="video/webm"></source>
        <source src="/template/video/medalyst_bg_01.mp4" type="video/mp4"></source>
     </video>
     <div id="videoMessage" >
        <div  class="owlslider" style="width: 50%; height: 100%; text-align: center; margin: 0 auto;">

            <div style="display: inline-block;">
             <h1>Достигай успеха</h1>
             <h2>...каждый день</h2>
             <h3>Medalyst - сервис контроля достижений</h3>
             <p class="videoClick" >
             <a href="<?=Yii::$app->urlManager->createUrl(['user/register' ])?>" class="mdlst-button mdlst-button-accent">Зарегистрироваться</a>
             </p>
             </div>
            <div  style="display: inline-block;">
             <h1>Достигай успеха</h1>
             <h2>...каждый день</h2>
             <h3>Medalyst - сервис контроля достижений</h3>
             <p class="videoClick" >
             <a href="<?=Yii::$app->urlManager->createUrl(['user/register' ])?>" class="mdlst-button mdlst-button-accent">Зарегистрироваться</a>
             </p>
             </div>
         </div>
        
     </div>
      
 </div>


 <style>
#videoDiv {width: 100%; height: 450px; position: relative; overflow: hidden; margin-top: -35px;}
#videoCurtain { position: absolute; background-color: black; opacity: 0.4; width: 100%; height:  100%; left: 0; top: 0; }
#video {width: 100%;  }
#videoBlock,#videoMessage {width: 100%; height: 450px; position: absolute; top: 0; left: 0;}
#videoMessage *{padding:0.4em; margin:0;}
#videoMessage {text-shadow: 2px 2px 2px #000000; color:white;z-index:99;  padding-top: 50px ; }
#videoMessage h1{font-size: 3em;color:#ffffff;text-align:center;}
#videoMessage h2{font-size: 2.5em;color:#ffffff;text-align:center;}
#videoMessage h3{font-size: 2.0em;color:#ffffff;text-align:center;}
.videoClick {text-align:center}
.videoClick a{color:white; font-size: 1.7em; text-shadow: none; cursor:pointer;cursor:hand; padding: 12px 35px !important;}
</style>