<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Achievement;
use app\models\ScalePointsBalance;
use app\models\Level;
use app\models\Notification;

echo $this->render('_panel.php');
?>
<!-- CONTENT -->
<div class="container">
    <div class="wc">
        <div class="container-cols">
            <?= $this->render("_menu.php") ?>
            <!-- container-content -->
            <div class="container-col container-col-2">
                <!-- Списко целей-->
                <div class="output">
                    
                   <div class="output-header">
                        <div class="mygoals-name-div">
                            <h2 class="mdlst-h2t-goals withButton">Новости</h2>
                      
                            <div class="clear"></div>
                        </div>
                    </div>
                    
                    <div class="news-wrapper">
                    <?php foreach($news as $new ) { 

                         Notification::renderNotificationHTML($new);
                        
                        }


                        if( empty($news) ){
                            Yii::$app->inviteFriends->form();
                        }
                        ?>

                    </div>

                    
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->