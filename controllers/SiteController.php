<?php

namespace app\controllers;

use app\models\LogCreatedir;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;
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
        $msg = '';
        $request = \Yii::$app->request;
        $getDirname = $request->get('dirname', '');
        if ($request->isPost) {
            $dirname = $request->post('name');
            if ($getDirname) {
                $dirname = $getDirname . '/' . $dirname;
            }
            $count = LogCreatedir::find()->where(['dirname' => $dirname])->count();
            if ($count > 0) {
                $msg = '目录已存在';
            } else {
                $s3 = Yii::$app->get('s3');
                $filename = $dirname . '/index.html';
                $exist = $s3->exist($dirname . '/');
                if ($exist) {
                    $msg = '目录被占用';
                } else {
                    $result = $s3->put($filename, '为了创建目录, 建立的空文件');

                    $logCreatedirModel = new LogCreatedir();
                    $logCreatedirModel->dirname = $dirname;
                    $logCreatedirModel->save();

                    $msg = '创建成功';
                }
            }
        }
        if ($getDirname) {
            $logs = LogCreatedir::find()->where("dirname like '{$getDirname}/%'")->all();
        } else {
            $logs = LogCreatedir::find()->all();
        }
        return $this->render('createdir', [
            'msg' => $msg,
            'logs' => $logs,
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
