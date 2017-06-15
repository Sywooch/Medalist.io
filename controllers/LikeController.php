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



                    if( !empty($obj) ){
                        Alarm::addAlarm(Yii::$app->user->identity->id, $obj->user_id, Alarm::TYPE_LIKE, false, Yii::$app->request->get()['entity_class'], Yii::$app->request->get()['entity_id']);    
                    }
                    



                 
                }
    		}
    	}

        echo json_encode($result);
    }

    public function actionAjaxGetLikes()
    {
        return $this->render('ajax-get-likes');
    }

}
