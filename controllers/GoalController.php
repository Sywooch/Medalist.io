<?php

namespace app\controllers;

use Yii;
use app\models\Goal;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Tag;
use app\models\Category;
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
