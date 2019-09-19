<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '文件列表';
$this->params['breadcrumbs'][] = $this->title;
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
    <h1>上传文件</h1>
    <div class="row">
        <div class="col-lg-5">
            <div class="case">
                <div class="upload" data-num="10" data-type="png,jpg,jpeg,gif" action='<?=Url::to(['site/upload', 'dirname' => \Yii::$app->request->get('dirname', '')]);?>' id='case1'></div>
            </div>
        </div>
    </div>
    <h1><?=Html::encode($this->title);?></h1>
    <form method="POST" action="<?php echo Url::to(['site/deletefiles', 'dirname' => \Yii::$app->request->get('dirname', '')]); ?>">
    <table id="datatable" border="1" cellpadding="10">
        <?php foreach ($logs as $key => $log) {?>
        <tr>
            <td class="unnamed1"><input type="checkbox" name="ids[]" value="<?=$log['id'];?>"></td>
            <td class="unnamed1"><?=$log['dirname'];?></td>
            <td class="unnamed1"><?=$log['filename'];?></td>
            <td class="unnamed1"><?=$log['url'];?></td>
            <td class="unnamed1"><?php if ($log['isImage']) {?><img src="<?=$log['url'];?>" width="120px" height="120px"><?php }?></td>
            <td class="unnamed1">
                <a href="<?=Url::to(['site/deletefile', 'id' => $log['id'], 'dirname' => \Yii::$app->request->get('dirname', '')]);?>" onClick="return confirm('确定要删除吗? 删除后无法恢复');">删除</a>
            </td>
        </tr>
        <?php }?>
    </table>
    <div class="form-group">
        <?=Html::submitButton('批量删除', ['class' => 'btn btn-primary', 'name' => 'createdirform-button']);?>
    </div>
    </form>
</div>
<script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="<?=Url::to('@web/upload_h5/jQuery.upload.uploadfile.js');?>"></script>
<script>
$(function() {
    $("#case1").upload(
        function(_this, data) {
            console.log(data)
        }
    );
})
</script>
