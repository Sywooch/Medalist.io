<?php

namespace app\controllers;

use Yii;
use app\models\Like;
use app\models\Alarm;
use app\models\Achievement;
use app\models\Comment;
use app\models\Goal;
class LikeController extends \yii\web\Controller
{
    public function actionAjaxAddLike()
    {
    	$result = [];

        $result['success'] = false;

    	if( !empty(Yii::$app->request->get()) && !Yii::$app->user->isGuest){
            $result['step1'] = true;
    		if (!empty(Yii::$app->request->get()['entity_class']) && !empty(Yii::$app->request->get()['entity_id'])){
                $result['step2'] = true;
    			$point = !empty(Yii::$app->request->get()['point'])?Yii::$app->request->get()['point']:1;

                $res = Like::addLikeToObject( Yii::$app->request->get()['entity_class'], Yii::$app->request->get()['entity_id'], $point );
                   $result['res'] = $res;
                   $result['d1'] = Yii::$app->request->get()['entity_class'];
                   $result['d2'] = Yii::$app->request->get()['entity_id'];
                   $result['d3'] = $point;
                if( $res !== false ){
                    $result['step3'] = true;
                    $result['success'] = true;


                    $className = "app\\models\\".Yii::$app->request->get()['entity_class'];

                    $obj = $className::findOne(Yii::$app->request->get()['entity_id']); 

                    if( Yii::$app->request->get()['entity_class'] == "Achievement" ){
                        $likeCount = Like::getLikesOfObjectCount($obj);
                        $dislikeCount = Like::getDislikesOfObjectCount($obj);
                        if( ($likeCount - $dislikeCount) >= Achievement::LIKES_TO_CONFIRM ){
                            $obj->setStatusApproved(1);
                        }
                    }
                    

                    if( !empty($obj) && !empty($obj->user_id)){
                        Alarm::addAlarm(Yii::$app->user->identity->id, $obj->user_id, Alarm::TYPE_LIKE, false, Yii::$app->request->get()['entity_class'], Yii::$app->request->get()['entity_id']);    
                    }


                    



                 
                }
    		}
    	}

        echo json_encode($result);
    }

    public function actionAjaxGetLikes()
    {
       
       $result = [];
       $result['success'] = false;

       if( !empty(Yii::$app->request->get())  ){
            $result['step1'] = true;
            if (!empty(Yii::$app->request->get()['entity_class']) && !empty(Yii::$app->request->get()['entity_id'])){
                
        
                    $className = "app\\models\\".Yii::$app->request->get()['entity_class'];

                    $obj = $className::findOne(Yii::$app->request->get()['entity_id']); 

                    $likes = Like::getLikesOfObjectCount($obj);
                    $dislikes = Like::getDislikesOfObjectCount($obj);

                    $result['likes'] = $likes;
                    $result['dislikes'] = $dislikes;
                    $result['success'] = true;


 
            }
        }

         echo json_encode($result);
    }

}
