<?php

namespace app\controllers;

use app\models\Badge;
use Yii;

class BadgeController extends \yii\web\Controller
{
    public function actionAjaxGetInfo()
    {

    	$result = [];

    	$get = Yii::$app->request->get();
    	$post = Yii::$app->request->post();
   

    	$badge = Badge::findOne( $get['badge_id'] );
        $scalePoints = $badge->getBadgeScalePoints();

    	$result['badge'] = [
    		'badge_id' => $badge->badge_id,
            'name' => $badge->name,
            'description' => $badge->description,
    		'picture' => $badge->picture,
            'points' => $scalePoints['points'],
            'scale' => $scalePoints['scale']->name
    	];
    	$result['get'] = $get;
    	$result['post'] = $post;
     

        echo json_encode($result);
    }

}
