<?php

namespace app\controllers;

use app\models\CreatedirForm;
use app\models\LogCreatedir;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $s3 = Yii::$app->get('s3');
        $result = $s3->list('test/');
        var_dump($result->get('Contents'));exit;
        // return $result->toArray();
        // return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionCreatedir()
    {
        $model = new CreatedirForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $logCreatedirModel = new LogCreatedir();
            $logCreatedirModel->dirname = $model->name;
            return $logCreatedirModel->save();
        }
        return $this->render('createdir', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionUpload()
    {

        //

        // $result = $s3->upload('test/test.txt', '/work/d/phpapps/yii-aws/test.txt');

        // $result = $s3->put('test/test1.txt', 'body');

        // var_dump($result);exit;
        return $this->render('upload');
    }
}
