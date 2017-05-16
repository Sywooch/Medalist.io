<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Quest;
use app\models\Category;
use app\models\User;
use app\models\Tag;

class SiteController extends Controller
{
    var $layout = 'medalist_inner';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        if( !Yii::$app->user->isGuest ) {
            $this->redirect(['personal/viewprofile', 'user_id' => Yii::$app->user->identity->id]);
        }
        $tag = Tag::findOne(6);

        $interests = $tag->getInterests();
        $int = array();
        foreach ($interests as $interest) {
            $int[] = $interest->interest_id;
        }
    
      
        return $this->render('index', ['interests' => '', 'interests2' => '']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAjaxUploadImage()
    { 

        $this->enableCsrfValidation = false;

        $ds = DIRECTORY_SEPARATOR;  //1
     
        $storeFolder = '/var/www/medalyst.ok/basic/web/uploads/ajax_upload/';   //2
         
        if (!empty($_FILES)) {
             
            $tempFile = $_FILES['file']['tmp_name'];          //3             
              
            $targetPath = $storeFolder;  //4
            $info = pathinfo( $_FILES['file']['name'] );
            $newFilename = date("YmdHis").md5(time().rand(0,10000)).".".$info['extension'];
             
            $targetFile =  $targetPath. $newFilename ;  //5

            echo $targetPath. $newFilename ;
         
            move_uploaded_file($tempFile,$targetFile); //6
             
        }
      
       
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
