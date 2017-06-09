<?php 
namespace app\components;
 
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Comment;
 
class CommentComponent extends Component
{
    public function renderForm(   )
    {

     
        ?>
<div class="like-controll <?=$class?>" data-obj="<?=$classname?>" data-id="<?=$id?>">
    <div class="like-controll-plus js-add-like <?=$class_active_plus?>" data-point="1" ><span></span><?=$plus?></div>
    <div class="like-controll-minus js-add-like <?=$class_active_minus?>"  data-point="-1" ><span></span><?=$minus?></div>
</div>
        <?
    }
    public function renderCommentCount( $num, $commentWrapperClass = false  )
    {

     
        ?>
            <div class="comment-controll js-get-comments" <?php if(!empty($commentWrapperClass) ) {  ?> data-class="<?=$commentWrapperClass?>" <? }?>><span></span><?=$num?></div>
        <?
    }
 
}