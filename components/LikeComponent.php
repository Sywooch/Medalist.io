<?php 
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Like;
use app\models\Achievement;
 
class LikeComponent extends Component
{
    public function renderWidget( $obj, $class = '' )
    {

        $classname = get_class( $obj );
        $classname = explode("\\",$classname);
        $classname = $classname[count($classname) - 1];
        $idVarName = strtolower($classname."_id");
        $id = $obj->{$idVarName};



        
        $likes = Like::getLikesOfObject( $obj );
        $plus = 0;
        $minus = 0;


        foreach ($likes as $like) {
            if( $like->point > 0){
                $plus++;
            }else{
                $minus++;
            }
        }

        $class_active_plus = "";
        $class_active_minus = "";

        if( !Yii::$app->user->isGuest){
 
            if( $liked = Like::getLikeByUserIdOfObject( $obj, Yii::$app->user->identity->id ) ){
                if( $liked->point > 0 ){

                    $class_active_plus = "like-controll-active";
                }else{
                      $class_active_minus = "like-controll-active";
                }
            } 
        }
        ?>
<div class="like-controll <?=$class?>" data-obj="<?=$classname?>" data-id="<?=$id?>">
    <div class="like-controll-plus js-add-like <?=$class_active_plus?>" data-point="1" ><span></span><?=$plus?></div>
    <div class="like-controll-minus js-add-like <?=$class_active_minus?>"  data-point="-1" ><span></span><?=$minus?></div>
<?if($classname == "Achievement"){
	$likesToConfirm = Achievement::LIKES_TO_CONFIRM;
	$moreLikes = $likesToConfirm -$plus+$minus;
	if($moreLikes>0){?>
		<div class="like-controll-more hint hint--bottom  hint--info" data-hint="Осталось набрать для подтверждения"><span></span><?=$likesToConfirm -$plus+$minus?></div>
	<?}
	 elseif($moreLikes<=0){?>
<!--		<div class="like-controll-more hint hint--bottom  hint--success" data-hint="Достижение подтверждено""><span></span></div>-->
		<a class="status-icon  hint--bottom-left  hint--success" style="background:lightgreen; margin-left:10px; top:5px;" aria-label="Достижение подтверждено">
			<svg style="width:24px;height:24px" viewBox="0 0 24 24">
			<path fill="#ffffff" d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
			</svg>
		</a>
	<?}?>
<?}?>
</div>
        <?
    }
 
}