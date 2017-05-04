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


    protected function renderComment($comment, $obj, $parent = true){

        if( $parent ){

            
        ?>
            <div class="comment-block comment-id-<?=$comment->comment_id?>">
                <div class="comment-block-data">
                    <div class="comment-block-data-user"></div>
                    <div class="comment-block-data-content"></div>
                </div>
                <div class="comment-block-answers">
                    <?php 
                        $comments = Comment::getCommentsOfObject( $obj, $comment->comment_id )->limit(0, 2 );
                        foreach( $comments as $c){
                            self::renderComment( $comment, $obj, false );
                        }
                    ?>
                </div>
                <div class="comment-block-controlls">
                    <sudo class="comment-block-controlls-response">Ответить</sudo>
                </div>
                
            </div>
        <?   
        }else{

             ?>
            <div class="comment-block  comment-block-sub comment-id-<?=$comment->comment_id?>" data-parent_comment_id="<?=$comment->parent_comment_id?>">
                <?=$comment->text?>
            </div>
            <? 

        }
    }

    public function renderCommentFeed(  $obj, $from = 0, $limit = 10 )
    {
        $comments = Comment::getCommentsOfObject( $obj, 0 )->limit( $from, $limit )->all();

        foreach( $comments as $com ){
            self::renderComment( $com, $obj );
        }
     
         
    }
 
}