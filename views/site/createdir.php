<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '创建目录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <h1><?=Html::encode($this->title);?></h1>
    <div class="row">
        <div class="col-lg-5">
            <div><?=$msg;?></div>
            <form method="POST" action="<?php echo Url::to(['site/index', 'dirname' => \Yii::$app->request->get('dirname', '')]); ?>">
                <div class="form-group">
                    <input type="text" name="name">
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
            <td>
                <a href="<?=Url::to(['site/index', 'dirname' => $log->dirname]);?>">查看子目录</a>
                <a href="<?=Url::to(['site/showfiles', 'dirname' => $log->dirname]);?>">查看文件</a>
                <a href="<?=Url::to(['site/deletedir', 'id' => $log->id, 'dirname' => \Yii::$app->request->get('dirname', '')]);?>" onClick="return confirm('确定要删除吗? 删除后无法恢复, 且会删除所有子文件夹和文件夹下面的文件');">删除</a>
            </td>
        </tr>
        <?php }?>
    </table>
</div>
