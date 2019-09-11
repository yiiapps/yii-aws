<?php

namespace app\controllers;

use app\models\LogCreatedir;
use app\models\LoginForm;
use app\models\LogUploadfile;
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
    public function actionIndex()
    {
        $msg = '';
        $request = \Yii::$app->request;
        $getDirname = $request->get('dirname', '');
        if ($request->isPost) {
            $dirname = $request->post('name');
            if (empty($dirname) || !$this->valiName($dirname)) {
                $msg = '名字不合法';
            } else {
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

    public function actionShowfiles()
    {
        $msg = '';
        $getDirname = Yii::$app->request->get('dirname', '');
        if (Yii::$app->request->isPost) {
            if (empty($_FILES['file']['name']) || !$this->valiName($_FILES['file']['name'])) {
                $msg = '名字不合法';
            } else {
                $s3 = Yii::$app->get('s3');
                $filename = $getDirname . '/' . $_FILES['file']['name'];
                $result = $s3->upload($filename, $_FILES['file']['tmp_name']);

                $modelLogUploadfile = new \app\models\LogUploadfile();
                $modelLogUploadfile->filename = $_FILES['file']['name'];
                $modelLogUploadfile->dirname = $getDirname;
                $modelLogUploadfile->url = $result->get('ObjectURL');
                $modelLogUploadfile->save();
                $msg = '添加成功';
            }
        }

        $logs = LogUploadfile::findAll(['dirname' => $getDirname]);
        return $this->render('showfiles', [
            'logs' => $logs, 'msg' => $msg,
        ]);
    }

    private function valiName($name)
    {
        if (preg_match('/^[a-zA-Z0-9\.\-_]+$/', $name, $matches)) {
            return true; //name合法
        } else {
            return false; //name 不合法
        }
    }
}
