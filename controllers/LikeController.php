<?php

namespace app\controllers;

use Yii;

class LikeController extends \yii\web\Controller
{
    public function actionAjaxAddLike()
    {
    	$result = [];

    	if( !empty(Yii::$app->request->get()) && !Yii::$app->user->isGuest){
    		if (!empty(Yii::$app->request->get()['entity_class']) && !empty(Yii::$app->request->get()['entity_id'])){
    			$point = !empty(Yii::$app->request->get()['point'])?Yii::$app->request->get()['point']:1;
    		}
    	}

        echo $result;
    }

    public function actionAjaxGetLikes()
    {
        return $this->render('ajax-get-likes');
    }

}
