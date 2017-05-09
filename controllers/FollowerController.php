<?php

namespace app\controllers;

use Yii;
use app\models\Follower;
use app\models\Notification;
use app\models\NotificationType;

class FollowerController extends \yii\web\Controller
{
    public function actionAjaxFollow()
    {
        $result = [];
        $result['success'] = false;
        if( !empty(Yii::$app->request->get() ) ){
        	$get = Yii::$app->request->get();
        	if ( !Yii::$app->user->isGuest ){


        		//Find if they are followers 
        		$areFollowers = Follower::find()->where(['user_id' =>Yii::$app->user->identity->id, 'to_user_id' =>$get['user_id'] ])->one();

        		if( !$areFollowers ){
	         		$follower = new Follower;
	        		$follower->user_id = Yii::$app->user->identity->id;
	        		$follower->to_user_id = $get['user_id'];
	        		$follower->date_created = date("Y-m-d H:i:s");

	        		if( $follower->save() ){
	        			$result['success'] = true;
	        			Notification::addNotification( $follower->user_id, NotificationType::NT_NEW_FOLLOWER , $follower);
	        		}       			
        		}





        	}else{
        		$result['error'] = 'Вы не авторизованы';
        	}
        }

        echo json_encode($result);
    }

}
