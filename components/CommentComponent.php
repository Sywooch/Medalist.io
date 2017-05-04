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
                    <div class="comment-block-data-user">
                        <div class="comment-block-data-user-pic"><img src="/template/img/_user-ava.png"></div>
                        <div class="comment-block-data-user-name"> <a class="comment-block-data-user-name-link">Иван Петров</a></div>
                        
                    </div>
                    <div class="comment-block-data-content">
                        <div class="comment-block-data-content-date">27.11.2010</div>
                        <div class="comment-block-data-content-content"><?=$comment->text?></div>
                        <div class="comment-block-controlls">
                            <sudo class="comment-block-controlls-response js-comment-makeresponse" data-id="<?=$comment->comment_id?>">Ответить</sudo>
                        </div>


                    </div>

    


                </div>
                <div class="comment-block-answers">
                    <?php 
                        $comments = Comment::getCommentsOfObject( $obj, $comment->comment_id )->offset(0)->limit(  2 )->all();

                        
                        foreach( $comments as $c){
                            self::renderComment( $c, $obj, false );
                        }
                    ?>
                </div>

                
            </div>
        <?   
        }else{

             ?>
            <div class="comment-block  comment-block-sub comment-id-<?=$comment->comment_id?>" data-parent_comment_id="<?=$comment->parent_comment_id?>">
                <div class="comment-block-data">
                    <div class="comment-block-data-user">
                        <div class="comment-block-data-user-pic"><img src="/template/img/_user-ava.png"></div>
                        <div class="comment-block-data-user-name"> <a class="comment-block-data-user-name-link">Иван Петров</a></div>
                        
                    </div>
                    <div class="comment-block-data-content">
                        <div class="comment-block-data-content-date">27.11.2010</div>
                        <div class="comment-block-data-content-content"><?=$comment->text?></div>
                       


                    </div>
                </div>  
            </div>
            <? 

        }
    }

    public function renderCommentFeed(  $obj, $from = 0, $limit = 10 )
    {
        $comments = Comment::getCommentsOfObject( $obj, 0 )->offset($from)->limit( $limit )->all();

       
        foreach( $comments as $com ){
            self::renderComment( $com, $obj );
        }
     
         
    }
 
}