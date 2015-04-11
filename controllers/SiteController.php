<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login', 'signup'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],                  
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
        SIGNUP
    */

    public function actionSignup()
    {
        $model = new User(['scenario' => 'signup']);
        $data = \Yii::$app->request->post();
        $notDataSended = !isset($data) || !$data;
        
        if($notDataSended || $this->passwordsAreNotEqual($data))
            return $this->getSignupForm($model);

        $model->username = $data['User']['username'];
        $model->email = $data['User']['email'];
        $model->password = $data['User']['password'];

        if( $model->validate() && $model->save() ){
            return $this->render('login', [
                'model' => $model
            ]);
        }
        else
            return $this->getSignupForm($model);
    }

    private function passwordsAreNotEqual($data){
        $password = $data['User']['password'];
        $repeatPassword = $data['repeatPassword'];
        return $password !== $repeatPassword;
    }

    private function getSignupForm($model){
        return $this->render('signup',[
                'model' => $model
            ]);
    }

    /**
        LOGIN
    */

    public function actionLogin()
    {
        // $data = \Yii::$app->request->post();
        // $notDataSended = !isset( $data );
        // $model = new User(['scenario' => 'login']);

        // if($notDataSended)        
        //     return $this->goBack();

        // $usernameOrEmail = $data['usernameOrEmail'];
        // $password = $data['password'];
        // $model = User::findByUsernameOrEmail($usernameOrEmail);
        // $model->setScenario('ĺogin');

        // if($model->validatePassword($password)){
            Yii::$app->user->login(new User);
            return $this->render('index');
        // }
    }

    public function actionLogout()
    {
        var_dump("SHHEEEEIIT..."); die;
        Yii::$app->user->logout();

        return $this->goHome();
    }

    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
    //         Yii::$app->session->setFlash('contactFormSubmitted');

    //         return $this->refresh();
    //     } else {
    //         return $this->render('contact', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }
}
