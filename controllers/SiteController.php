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
                    // $exist = $s3->exist($dirname . '/');
                    // if ($exist) {
                    //     $msg = '目录被占用';
                    // } else {
                    $result = $s3->put($filename, '为了创建目录, 建立的空文件');

                    $logCreatedirModel = new LogCreatedir();
                    $logCreatedirModel->dirname = $dirname;
                    $logCreatedirModel->save();

                    $msg = '创建成功';
                    $this->redirect(['site/index', 'dirname' => $getDirname]);
                    // }
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
                $this->redirect(['site/showfiles', 'dirname' => $getDirname]);
            }
        }

        $logs = LogUploadfile::findAll(['dirname' => $getDirname]);
        return $this->render('showfiles', [
            'logs' => $logs, 'msg' => $msg,
        ]);
    }

    public function actionShowfiles2()
    {
        return $this->render('showfiles2');
    }

    public function actionDeletefile()
    {
        $id = Yii::$app->request->get('id', 0);
        $id = intval($id);
        $dirname = Yii::$app->request->get('dirname', '');
        $logUploadfile = LogUploadfile::findOne($id);
        if (!$logUploadfile) {
            return '文件不存在';
        }

        $s3 = Yii::$app->get('s3');
        $result = $s3->delete("{$logUploadfile->dirname}/{$logUploadfile->filename}");
        $logUploadfile->delete();

        $this->redirect(['site/showfiles', 'dirname' => $dirname]);
    }

    public function actionFilesajax()
    {
        $key = Yii::$app->request->get('searchkey', '');
        if ($key) {
            $logs = LogUploadfile::find()->where("url like '%{$key}%'")->limit(200)->asArray()->all();
        } else {
            $logs = LogUploadfile::find()->limit(200)->asArray()->all();
        }

        return json_encode([
            'errno' => 0,
            'data' => $logs,
        ]);
    }

    public function actionSearchdir()
    {
        $key = Yii::$app->request->get('searchkey', '');
        if ($key) {
            $logs = LogCreatedir::find()->where("dirname like '%{$key}%'")->limit(200)->asArray()->all();
        } else {
            $logs = LogCreatedir::find()->limit(200)->asArray()->all();
        }

        return json_encode([
            'errno' => 0,
            'data' => $logs,
        ]);
    }

    public function actionDeletefiles()
    {
        $ids = Yii::$app->request->post('ids', []);
        $s3 = Yii::$app->get('s3');
        foreach ($ids as $key => $id) {
            $id = intval($id);
            $logUploadfile = LogUploadfile::findOne($id);
            if (!$logUploadfile) {
                return '文件不存在';
            }
            $result = $s3->delete("{$logUploadfile->dirname}/{$logUploadfile->filename}");
            $logUploadfile->delete();
        }
        $dirname = Yii::$app->request->get('dirname', '');

        $this->redirect(['site/showfiles', 'dirname' => $dirname]);
    }

    public function actionDeletefiles2()
    {
        $ids = Yii::$app->request->post('ids', []);
        $s3 = Yii::$app->get('s3');
        foreach ($ids as $key => $id) {
            $id = intval($id);
            $logUploadfile = LogUploadfile::findOne($id);
            if (!$logUploadfile) {
                return '文件不存在';
            }
            $result = $s3->delete("{$logUploadfile->dirname}/{$logUploadfile->filename}");
            $logUploadfile->delete();
        }
        // $dirname = Yii::$app->request->get('dirname', '');

        $this->redirect(['site/showfiles2']);
    }

    public function actionDeletedir()
    {
        $id = Yii::$app->request->get('id', 0);
        $id = intval($id);
        $dirname = Yii::$app->request->get('dirname', '');
        $logCreatedir = LogCreatedir::findOne($id);
        if (!$logCreatedir) {
            return '文件夹不存在';
        }

        $s3 = Yii::$app->get('s3');
        $logsFile = LogUploadfile::find()->where("dirname='{$logCreatedir->dirname}' or dirname like '{$logCreatedir->dirname}/%'")->all();
        foreach ($logsFile as $key => $logFile) {
            $result = $s3->delete("{$logFile->dirname}/{$logFile->filename}");
            $logFile->delete();
        }

        $logsDir = logCreatedir::find()->where("dirname like '{$logCreatedir->dirname}/%'")->all();
        foreach ($logsDir as $key => $logDir) {
            $result = $s3->delete("{$logDir->dirname}/index.html");
            $logDir->delete();
        }

        $result = $s3->delete("{$logCreatedir->dirname}/index.html");
        $logCreatedir->delete();

        $this->redirect(['site/index', 'dirname' => $dirname]);
    }

    private function valiName($name)
    {
        if (preg_match('/^[a-zA-Z0-9\.\-_]+$/', $name, $matches)) {
            return true; //name合法
        } else {
            return false; //name 不合法
        }
    }

    public function actionUpload()
    {
        $getDirname = Yii::$app->request->get('dirname', '');
        $data = [];
        if (empty($_FILES['file']['name']) || !$this->valiName($_FILES['file']['name'])) {
            $msg = '名字不合法';
            $errno = 1;
        } elseif (!$this->checkExt($_FILES['file']['name'])) {
            $msg = '不是图片';
            $errno = 2;
        } elseif ($_FILES['file']['size'] > 500 * 1024) {
            $msg = '图片大于500k';
            $errno = 3;
        } else {
            $s3 = Yii::$app->get('s3');
            $filename = $getDirname . '/' . $_FILES['file']['name'];
            $result = $s3->upload($filename, $_FILES['file']['tmp_name']);

            $url = $result->get('ObjectURL');

            $modelLogUploadfile = new \app\models\LogUploadfile();
            $modelLogUploadfile->filename = $_FILES['file']['name'];
            $modelLogUploadfile->dirname = $getDirname;
            $modelLogUploadfile->url = $url;
            $modelLogUploadfile->save();

            $msg = '添加成功';
            $errno = 0;
            $data = [
                'getDirname' => $getDirname,
                'fileinfo' => [
                    'filename' => $_FILES['file']['name'],
                    'dirname' => $getDirname,
                    'url' => $url,
                    'id' => $modelLogUploadfile->id,
                ],
            ];
        }

        return json_encode([
            'msg' => $msg,
            'errno' => $errno,
            'data' => $data,
        ]);
    }

    private function checkExt($filename)
    {
        $array = array("gif", "png", "jpg", "jpeg"); //赋值一个数组
        $tmp = explode(".", $filename); //用explode()函数把字符串打散成为数组。
        $extension = end($tmp); //用end获取数组最后一个元素
        if (in_array(strtolower($extension), $array)) {
            return true;
        } else {
            return false;
        }
    }

    public function actionZip()
    {
        $getDirname = Yii::$app->request->get('dirname', '');
        return $this->render('uploadzip', ['dirname' => $getDirname]);
    }

    public function actionZippost()
    {
        $getDirname = Yii::$app->request->get('dirname', '');
        $data = ['dirname' => $getDirname];
        if (empty($_FILES['file']['name']) || !$this->valiName($_FILES['file']['name'])) {
            $msg = '名字不合法';
            $errno = 1;
        } else {
            $tmp = explode(".", $_FILES['file']['name']);
            $extension = end($tmp);
            $extension = strtolower($extension);
            if ($extension == 'zip') {
                $uploadDir = Yii::$app->basePath . "/web/uploads";
                if ($getDirname) {
                    $uploadDir = $uploadDir . '/' . $getDirname;
                }
                $file = $uploadDir . '/' . $_FILES['file']['name'];
                if (!file_exists($file)) {
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir);
                    }
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
                        $zip = new \ZipArchive();
                        if ($zip->open($file) === true) {
                            if (!file_exists($uploadDir)) {
                                mkdir($uploadDir);
                            }
                            $zip->extractTo($uploadDir . '/');
                            $zip->close();
                            unlink($file);
                            $data['filelist'] = $this->push2awss3($uploadDir, $_FILES['file']['name']);
                            $msg = '成功';
                            $errno = 0;
                        } else {
                            $msg = 'zip非法';
                            $errno = 7;
                        }
                    } else {
                        $msg = '上传失败';
                        $errno = 6;
                    }
                } else {
                    $msg = '文件已存在';
                    $errno = 5;
                }

            } else {
                $msg = '不是zip文件';
                $errno = 4;
            }
        }

        return json_encode([
            'msg' => $msg,
            'errno' => $errno,
            'data' => $data,
        ]);
    }

    private function push2awss3($dir, $zipfilename = '')
    {
        $uploaddir = Yii::$app->basePath . "/web/uploads/";
        $handle = opendir($dir);
        $s3 = Yii::$app->get('s3');
        $rs = [];
        while (false !== ($file = readdir($handle))) {
            if ($file == "." || $file == ".." || $file == $zipfilename) {
                continue;
            }
            $s3dir = str_replace($uploaddir, '', $dir);
            $filename = $dir . '/' . $file;
            $s3filename = $s3dir . '/' . $file;
            if (is_dir($filename)) {
                $filename1 = $s3dir . '/index.html';
                $result = $s3->put($filename1, '为了创建目录, 建立的空文件');

                $count = LogCreatedir::find()->where(['dirname' => $s3dir])->count();
                if ($count < 1) {
                    $logCreatedirModel = new LogCreatedir();
                    $logCreatedirModel->dirname = $s3dir;
                    $logCreatedirModel->save();
                }

                $rsTmp = $this->push2awss3($filename);
                $rs = $rs + $rsTmp;
                @rmdir($filename);
            } else {
                $result = $s3->upload($s3filename, $filename);

                $url = $result->get('ObjectURL');

                $modelLogUploadfile = new \app\models\LogUploadfile();
                $modelLogUploadfile->filename = $s3filename;
                $modelLogUploadfile->dirname = $s3dir;
                $modelLogUploadfile->url = $url;
                $modelLogUploadfile->save();

                $rs[] = [
                    'id' => $modelLogUploadfile->id,
                    'url' => $url,
                    'dirname' => $s3dir,
                    'filename' => $s3filename,
                ];
                unlink($filename);
            }
        }
        closedir($handle);
        return $rs;
    }
}
