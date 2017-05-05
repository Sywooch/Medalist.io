<?php

namespace app\controllers;

use Yii;
use app\models\Comment;

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
           Yii::$app->comment->renderComment( $comment );
        }else{
            echo "";
        }
    }

}
