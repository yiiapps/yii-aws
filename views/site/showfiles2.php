<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '文件列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?=Html::encode($this->title);?></h1>
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
    <form method="POST" action="<?php echo Url::to(['site/deletefiles2']); ?>">
    <table id="datatable" border="1" cellpadding="10">
    </table>
    <div class="form-group">
        <?=Html::submitButton('批量删除', ['class' => 'btn btn-primary', 'name' => 'createdirform-button']);?>
    </div>
    </form>
</div>
<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?=Url::to('@web/jQuery-File-Upload-10.2.0/js/vendor/jquery.ui.widget.js');?>"></script>
<script type="text/javascript" src="<?=Url::to('@web/jQuery-File-Upload-10.2.0/js/jquery.iframe-transport.js');?>"></script>
<script type="text/javascript" src="<?=Url::to('@web/jQuery-File-Upload-10.2.0/js/jquery.fileupload.js');?>"></script>
<script>
    $(function(){
        $.get('<?=Url::to(['site/filesajax']);?>',function(data){
            for(var i in data.data){
                var fileinfo = data.data[i];
                var content = "<tr>"+
                "<td class=\"unnamed1\"><input type=\"checkbox\" name=\"ids[]\" value=\""+fileinfo.id+"\"></td>"+
                    "<td class=\"unnamed1\">"+fileinfo.dirname+"</td>"+
                    "<td class=\"unnamed1\">"+fileinfo.filename+"</td>"+
                    "<td class=\"unnamed1\">"+fileinfo.url+"</td>"+
                    // "<td class=\"unnamed1\">"+
                    //     "<a href=\"+delurl+\" onClick=\"return confirm('确定要删除吗? 删除后无法恢复');\">删除</a>"+
                    // "</td>"+
                "</tr>";
                $('#datatable').prepend(content);
            }
        },'json')
    });
    $('#fileupload').fileupload({
        dataType: 'json',
        url: "<?=Url::to(['site/upload', 'dirname' => \Yii::$app->request->get('dirname', '')]);?>",//文件的后台接受地址
        //设置进度条
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        },
        //上传完成之后的操作，显示在img里面
        done: function (e, data){
            console.log(data.result);
            $(".uploadmsg").html(data.result.msg);
            if (!data.result.errno) {
                var delurl = "<?=Url::to(['site/deletefile']);?>"+"?id="+data.result.data.fileinfo.id+"&dirname="+data.result.data.getDirname;
                var content = "<tr>"+
                "<td class=\"unnamed1\"><input type=\"checkbox\" name=\"ids[]\" value=\""+data.result.data.fileinfo.id+"\"></td>"+
                    "<td class=\"unnamed1\">"+data.result.data.fileinfo.dirname+"</td>"+
                    "<td class=\"unnamed1\">"+data.result.data.fileinfo.filename+"</td>"+
                    "<td class=\"unnamed1\">"+data.result.data.fileinfo.url+"</td>"+
                    "<td class=\"unnamed1\">"+
                        "<a href=\"+delurl+\" onClick=\"return confirm('确定要删除吗? 删除后无法恢复');\">删除</a>"+
                    "</td>"+
                "</tr>";
                $('#datatable').prepend(content);
            }
        }
    });
</script>
