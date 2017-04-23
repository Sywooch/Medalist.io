<?php

namespace app\controllers;
use app\models\Achievement;
use Yii;

class AchievementController extends \yii\web\Controller
{
    public function actionAjaxAddAchievement()
    {
        $result = [];
        $post = Yii::$app->request->post();

        if( !empty($post) ){
            $achievement = new Achievement;

            if( $achievement->save() ){
                $result['success'] = true;
            }
        }

        echo json_encode($result);
    }

    public function actionAjaxCommentAchievement()
    {
        return $this->render('ajax-comment-achievement');
    }

    public function actionAjaxLikeAchievement()
    {
        return $this->render('ajax-like-achievement');
    }

    public function actionAjaxUpdateAchievement()
    {
        return $this->render('ajax-update-achievement');
    }

}
