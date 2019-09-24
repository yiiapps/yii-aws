<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '上传Zip';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('http://libs.baidu.com/jquery/1.10.2/jquery.min.js');
$this->registerJsFile('@web/upload_h5/jQuery.upload.uploadzip.js');
$this->registerJsFile('@web/js/site/zip.js');
?>

<link rel="stylesheet" href="<?=Url::to('@web/upload_h5/upload.css');?>">
<style type="text/css">
    <!--
    .unnamed1 {
    padding-top: 1px;
    padding-right: 5px;
    padding-bottom: 1px;
    padding-left: 5px;
    }
    -->
</style>
<div class="site-about">
    <h1><?=Html::encode($this->title);?>::当前目录(<?=$dirname ?: '跟目录';?>)</h1>
    <div class="row">
        <div class="col-lg-5">
            <div class="case">
                <div class="upload" data-num="1" data-type="zip" action='<?=Url::to(['site/zippost', 'dirname' => \Yii::$app->request->get('dirname', '')]);?>' id='case1'></div>
            </div>
        </div>
    </div>
    <h1>文件列表</h1>
    <form method="POST" action="<?php echo Url::to(['site/deletefiles', 'dirname' => \Yii::$app->request->get('dirname', '')]); ?>">
    <table id="datatable" border="1" cellpadding="10">
    </table>
    </form>
</div>
