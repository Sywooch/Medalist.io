<?php
/* @var $this yii\web\View */
use app\models\Goal;
use app\models\Achievement;
use app\models\ScalePointsBalance;
use app\models\Level;
use app\models\Alarm;

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
                            <h2 class="mdlst-h2t-goals withButton">Уведомления</h2>
                      
                            <div class="clear"></div>
                        </div>
                    </div>
 

                    
    <!-- notificationslist -->
        <div id="notificationslist" class="notificationslist"  >
            <div class="notificationslist-close"></div>
             <div class="notificationslist-blocks">
                
                <?php foreach($alarms as $alarm){ 
                    Alarm::renderAlarmBlockHTML($alarm, true);
                    if( $alarm->status == 0){
                        $alarm->status = 1;
                        $alarm->save();
                    }
                } ?>


             </div>
            
        </div>
        <!-- .notificationslist END-->

                    
                </div>
                <!--output-->
                <!-- Списко целей-->
            </div>
        </div>
    </div>
</div>

<!-- . CONTENT END -->