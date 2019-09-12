<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '文件列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?=Html::encode($this->title);?></h1>
    <div class="row">
        <div class="col-lg-5">
            <div><?=$msg;?></div>
            <form method="POST" enctype="multipart/form-data" action="<?php echo Url::to(['site/showfiles', 'dirname' => \Yii::$app->request->get('dirname', '')]); ?>">
                <div class="form-group">
                    <input type="file" name="file">
                </div>
                <div class="form-group">
                    <?=Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'createdirform-button']);?>
                </div>
            </form>
        </div>
    </div>
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
    <form method="POST" action="<?php echo Url::to(['site/deletefiles', 'dirname' => \Yii::$app->request->get('dirname', '')]); ?>">
    <table border="1" cellpadding="10">
        <?php foreach ($logs as $key => $log) {?>
        <tr>
            <td class="unnamed1"><input type="checkbox" name="ids[]" value="<?=$log->id;?>"></td>
            <td class="unnamed1"><?=$log->dirname;?></td>
            <td class="unnamed1"><?=$log->filename;?></td>
            <td class="unnamed1"><?=$log->url;?></td>
            <td class="unnamed1">
                <a href="<?=Url::to(['site/deletefile', 'id' => $log->id, 'dirname' => \Yii::$app->request->get('dirname', '')]);?>" onClick="return confirm('确定要删除吗? 删除后无法恢复');">删除</a>
            </td>
        </tr>
        <?php }?>
    </table>
    <div class="form-group">
        <?=Html::submitButton('批量删除', ['class' => 'btn btn-primary', 'name' => 'createdirform-button']);?>
    </div>
    </form>
</div>
