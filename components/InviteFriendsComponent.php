<?php 
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class InviteFriendsComponent extends Component
{

    static $shareScriptsLoaded = false;

    const DATE_FORMAT = 'd.m.Y H:i';
    const DATE_FORMAT_SHORT = 'd.m.Y';

    public function form( $title = false, $subtitle = false ){
        if( $title === false ) { $title = 'Пригласите друзей'; }
        if( $subtitle === false ) { $subtitle = 'У вас нет друзей. Чтобы достигать все больших и больших высот, кто-то должен контролировать вас.'; }
        ?>
            <div class="invitefriends-widget">

                <div class="invitefriends-widget-screen invitefriends-widget-screen-1">
                    <div class="invitefriends-widget-screen-1-titleblock invitefriends-widget-screen-1-titleblock1">
                        <div class="invitefriends-widget-screen-1-title"><?=$title?></div>
                        <div class="invitefriends-widget-screen-1-subtitle"><?=$subtitle?></div>
                    </div>
                    <div class="invitefriends-widget-screen-1-titleblock invitefriends-widget-screen-1-titleblock2" >
                        <div class="invitefriends-widget-screen-1-title">Добавляйте емейлы через запятую</div>
                    </div>

                    <div class="invitefriends-widget-screen-1-form">
                        <div class="invitefriends-widget-screen-1-form-controlls">
                            <input type="text" class="js-invitefriends-input" placeholder="@Почты друзей через запятую">
                            <div class="invitefriends-widget-screen-1-form-controlls-add">
                                <? Yii::$app->decor->button('Добавить', "", 'js-invitefriends-addemail')?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="invitefriends-widget-screen invitefriends-widget-screen-2" style="display: none">
                    <div class="invitefriends-widget-screen-2-block">
                        <div class="invitefriends-widget-screen-2-emails js-invitefriends-emaillist">
                            
                        </div>
                        <div class="invitefriends-widget-screen-2-multiplier">
                            x 10
                        </div>
                        <div class="invitefriends-widget-screen-2-sum">
                            = <span>0</span>
                        </div>
                    </div>

                    <div class="invitefriends-widget-screen-2-info">Вы получите эти баллы при успешной регистрации в Медалисте ваших друзей.</div>
                    <div class="invitefriends-widget-screen-2-controlls">
                         <? Yii::$app->decor->button('Пригласить в медалист', "", 'js-invitefriends-invite mdlst-button-danger')?>
                    </div>
                        

                </div>

                <div class="invitefriends-widget-screen invitefriends-widget-screen-3" style="display: none;">
                    <div class="" style="text-align: center;">
                        <div class="invitefriends-widget-screen-1-title">На указанные емейлы высланы приглашения</div>
                        <div class="invitefriends-widget-screen-1-subtitle">Как только ваш друг зарегистрируется, вы получите баллы.</div>
                    </div>

                </div>

            </div>
        <?
       
    }

    

 
 
 
}