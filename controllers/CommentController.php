<?php

namespace app\controllers;

use app\models\Achievement;
use app\models\Comment;
use app\models\Alarm;

use app\models\Goal;
use Yii;


class CommentController extends \yii\web\Controller
{
    public function actionAjaxAddComment()
    {
      $result = [];

        $result['success'] = false;

        if( !empty(Yii::$app->request->get()) && !Yii::$app->user->isGuest){
            $result['step1'] = true;
            if (!empty(Yii::$app->request->get()['entity_class']) && !empty(Yii::$app->request->get()['entity_id'])){
                $result['step2'] = true;
              

                $res = Comment::addCommentToObject( Yii::$app->request->get()['entity_class'], Yii::$app->request->get()['entity_id'], Yii::$app->request->get()['text'],  Yii::$app->request->get()['parent_comment_id']);


                  
                if( $res !== false ){
                    $result['step3'] = true;
                    $result['success'] = true;
                    $result['comment_id'] = $res;
                    $result['parent_comment_id'] = (int)Yii::$app->request->get()['parent_comment_id'];
                    $className = "app\\models\\".Yii::$app->request->get()['entity_class'];

                    $obj = $className::findOne(Yii::$app->request->get()['entity_id']); 



                    if( !empty($obj)  ){

                        if( !empty(Yii::$app->request->get()['parent_comment_id']) ){
                            $c = Comment::findOne(Yii::$app->request->get()['parent_comment_id']);
                            Alarm::addAlarm(Yii::$app->user->identity->id, $obj->user_id, Alarm::TYPE_COMMENT, false, 'Comment',  $c->comment_id);        
                        }else {
                            Alarm::addAlarm(Yii::$app->user->identity->id, $obj->user_id, Alarm::TYPE_COMMENT, false, Yii::$app->request->get()['entity_class'], Yii::$app->request->get()['entity_id']);     
                        }
                        
                    }
                    

                 
                }
            }
        }

        echo json_encode($result);

    }

    public function actionAjaxDeleteComment()
    {
        return $this->render('ajax-delete-comment');
    }

    public function actionAjaxGetComments()
    {
        return $this->render('ajax-get-comments');
    }
    public function actionAjaxGetCommentHtml()
    {
        if( !empty(Yii::$app->request->get()['comment_id'] ) ){
           
            $comment = Comment::findOne( Yii::$app->request->get()['comment_id']  );

            //ANSWER?
            if( empty(Yii::$app->request->get()['parent_comment_id'] ) ) {
                Yii::$app->comment->renderComment( $comment, false, true, 'ajax-prepended' );
            }else{
                Yii::$app->comment->renderComment( $comment, false, false, 'ajax-prepended'  );
            }
           
        }else{
            echo "";
        }
    }

}
