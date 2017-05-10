<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Achievement;
use app\models\ScalePointsBalance;
use app\models\Level;
use app\models\Notification;

echo $this->render('_panel.php');
?>
<link rel="stylesheet" href="/template/css/goals.css">
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
                    
                    <?php foreach($news as $new ) { 
                    
                         Notification::renderNotificationHTML($new);
                        }?>

                    
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->