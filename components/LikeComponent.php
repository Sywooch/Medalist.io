<?php 
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Like;
 
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
    <div class="like-controll-plus js-add-like" data-point="1" ><span></span><?=$plus?></div>
    <div class="like-controll-minus js-add-like"  data-point="-1" ><span></span><?=$minus?></div>
</div>
        <?
    }
 
}