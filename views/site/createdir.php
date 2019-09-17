<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '创建目录';
$this->params['breadcrumbs'][] = $this->title;
?>
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
    <div class="row">
        <div class="col-lg-5">
            <div>搜索文件夹</div>
            <form method="POST" action="<?php echo Url::to(['site/searchdir', 'dirname' => \Yii::$app->request->get('dirname', '')]); ?>">
                <div class="form-group">
                    <input type="text" id="searchkey">
                </div>
                <div class="form-group">
                    <button id="searchbt">搜索</button>
                </div>
            </form>
        </div>
    </div>
    <table id="datatable" border="1">
        <?php foreach ($logs as $key => $log) {?>
        <tr>
            <td class="unnamed1"><?=$log->dirname;?></td>
            <td class="unnamed1">
                <a href="<?=Url::to(['site/index', 'dirname' => $log->dirname]);?>">查看子目录</a>
                <a href="<?=Url::to(['site/showfiles', 'dirname' => $log->dirname]);?>">查看文件</a>
                <a href="<?=Url::to(['site/deletedir', 'id' => $log->id]);?>" onClick="return confirm('确定要删除吗? 删除后无法恢复, 且会删除所有子文件夹和文件夹下面的文件');">删除</a>
            </td>
        </tr>
        <?php }?>
    </table>
</div>
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script>
    $(function(){
        $('#searchbt').click(function(){
            var url = '<?=Url::to(['site/filesajax']);?>';
            $('table#datatable').empty();

            $.get('<?=Url::to(['site/searchdir']);?>?searchkey='+$('#searchkey').val(),function(data){
                var dirlistUrl="<?=Url::to(['site/index']);?>";
                var showfilesUrl = "<?=Url::to(['site/showfiles']);?>";
                var deletedirUrl = "<?=Url::to(['site/deletedir']);?>";
                for(var i in data.data){
                    var item = data.data[i];
                    console.log(item)
                    var content = "<tr>"+
                        "<td class=\"unnamed1\">"+item.dirname+"</td>"+
                        "<td class=\"unnamed1\">"+
                            "<a href=\""+dirlistUrl+"?dirname="+item.dirname+"\">查看子目录</a>&nbsp; "+
                            "<a href=\""+showfilesUrl+"?dirname="+item.dirname+"\">查看文件</a>&nbsp; "+
                            "<a href=\""+deletedirUrl+"?id="+item.id+"\" onClick=\"return confirm('确定要删除吗? 删除后无法恢复, 且会删除所有子文件夹和文件夹下面的文件');\">删除</a>&nbsp; "+
                        "</td>"+
                    "</tr>";
                    $('#datatable').prepend(content);
                }
            },'json')
            return false;
        });
    });
</script>