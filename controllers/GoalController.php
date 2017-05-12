<?php

namespace app\controllers;

use Yii;
use app\models\Goal;
use app\models\GoalSubtask;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Tag;
use app\models\Category;
use app\models\Notification;
use app\models\NotificationType;
/**
 * GoalController implements the CRUD actions for Goal model.
 */
class GoalController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Goal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Goal::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->goal_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Goal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->goal_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Goal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionAjaxAddGoalSubtask(){
        $result = [];

        $result['success'] = false;

        if( !empty(Yii::$app->request->post() )){
            $post = Yii::$app->request->post();

            if( !empty($post['name'])){
                $goal = new GoalSubtask;

                $goal->name = $post['name'];
                $goal->date_created = date("Y-m-d H:i:s");
                $goal->goal_id = $post['goal_id'];
                $goal->goal_subtask_parent_id = 0;
                $goal->deadline = !empty($post['deadline'])?date("Y-m-d H:i:s", strtotime($post['deadline'])):"";
                

                if( $goal->save() ){

  

                    $result['goal_subtask_id'] = $goal->goal_subtask_id;
                    $result['goal_id'] = $goal->goal_id;
                    $result['posted'] = $post;
                    $result['success'] = true;
                }else{
                    $result['errors'] = $goal->errors;
                }
            }
        }

        return json_encode($result);
    }


    public function actionAjaxAddGoal(){
        $result = [];

        $result['success'] = false;

        if( !empty(Yii::$app->request->post() )){
            $post = Yii::$app->request->post();

            if( !empty($post['name'])){
                $goal = new Goal;

                $goal->name = $post['name'];
                $goal->difficulty = $post['difficulty'];
                $goal->description = $post['description'];
                $goal->date_created = date("Y-m-d H:i:s");
                $goal->deadline = date("Y-m-d H:i:s", strtotime($post['deadline']));
                $goal->user_id = Yii::$app->user->identity->id;

                if( $goal->save() ){


                    //NOTIFICATION - NEW ACHIEVEMENT 
                    Notification::addNotification( $goal->user_id,  NotificationType::NT_NEW_GOAL,  $goal);


                    if( !empty($post['interests']) ) {
                        //Todo - attachTags
                        Tag::attachTagsToObject( $goal, $post['interests'] );
                        //Todo - attachInterests 

                        //Todo - attachCategory 
                        $tags = $goal->getTags();
                        $tagIDs = [];
                        foreach ($tags as $tag) {
                            $tagIDs = $tag->tag_id;
                        }
                        $category_id = Category::getByTagIDs($tagIDs);
                        $goal->category_id = $category_id;
                        $goal->save();

                    }

                


                    $result['goal_id'] = $goal->goal_id;
                    $result['success'] = true;
                }else{
                    $result['errors'] = $goal->errors;
                }
            }
        }

        return json_encode($result);
    }


    public function actionAjaxCalcGoalProgress(){
        $result = [];

        $result['success'] = false;

        if( !empty(Yii::$app->request->get() )){
            $get = Yii::$app->request->get();

            if( !empty($get['goal_id'])){
                $g = Goal::findOne( $get['goal_id']);

                $result['progress'] = $g->getProgressPercent();
                $result['success'] = true;
            }
        }

        return json_encode($result);
    }

    public function actionAjaxSetGoalSubtaskComplete(){
        $result = [];

        $result['success'] = false;

        if( !empty(Yii::$app->request->get() )){
            $get = Yii::$app->request->get();

            if( !empty($get['goal_subtask_id'])){
                $g = GoalSubtask::findOne( $get['goal_subtask_id'] );

                $g->completed = ((int)$g->completed==1)?0:1;
                if( $g->save() ){

                    //Force all subtasks to be completed or not !
                    $g->setSubtasksCompleted( $g->completed );
                    
                    $result['status'] = $g->completed ; 
                    $result['progress'] = $g->getProgressPercent() ; 
                    $result['success'] = true;   
                }

                
            }
        }

        return json_encode($result);
    }





    public static function actionAjaxRenderGoalSubtaskHtml(  ){

        $get = Yii::$app->request->get();

        $goalSubtask = GoalSubtask::findOne($get['goal_subtask_id']);
        $parentGoal = $goalSubtask->getGoal()->one();

        $goalUID = "ListbGoal".$parentGoal->goal_id."s".$goalSubtask->goal_subtask_id;

        ?>

<li class="subtask-container">
            <div class="subtask-top">
                <div class="subtask-top-left ">
                    <div class="input-check">
                        <input id="<?=$goalUID?>" name= value="<?=$goalUID?>" type="checkbox">
                        <label for="<?=$goalUID?>" class="subtask-top-name"><?=$get['no']?>. <?=$goalSubtask->name;?> </label>
                    </div>
                    <div class="subtask-progress">
                        <div class="interests-selector-scale-viewport userpanel-info-scale-scale subtask-progress-height">
                            <div class="interests-selector-scale-track subtask-progress-height" style="margin-left: -100%;"></div>
                        </div>
                    </div>
                    <span class="mygoals-dead color-red subtask-top-dead"><? if(!empty( $goalSubtask->deadline) ) {  echo date("d.m.Y", strtotime($goalSubtask->deadline));  } ?></span>
                </div>
                <?=Yii::$app->decor->plus('');?>
            </div>
            <div class="subtask-bottom"></div>

        <ul class="subtask-points">


        </ul>

</li>
        <?
    }

    /**
     * Finds the Goal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
