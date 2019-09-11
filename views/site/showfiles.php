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
    <table border="1">
        <?php foreach ($logs as $key => $log) {?>
        <tr>
            <td width="300"><?=$log->dirname;?></td>
            <td width="300"><?=$log->filename;?></td>
            <td><?=$log->url;?></td>
        </tr>
        <?php }?>
    </table>
</div>
