<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '上传Zip';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?=Html::encode($this->title);?>::当前目录(<?=$dirname ?: '跟目录';?>)</h1>
    <div class="row">
        <div class="col-lg-5">
            <input id="fileupload" type="file" name="file">
            <div class="bar" style="width: 0%;"></div>
            <div class="uploadmsg"></div>
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
    <h1>文件列表</h1>
    <form method="POST" action="<?php echo Url::to(['site/deletefiles', 'dirname' => \Yii::$app->request->get('dirname', '')]); ?>">
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
    $('#fileupload').fileupload({
        dataType: 'json',
        url: "<?=Url::to(['site/zippost', 'dirname' => \Yii::$app->request->get('dirname', '')]);?>",//文件的后台接受地址
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
                var content = '';
                for(var r in data.result.data.filelist) {
                    var fileinfo=data.result.data.filelist[r]
                    console.log(fileinfo);
                    // var delurl = "<?=Url::to(['site/deletefile']);?>"+"?id="+fileinfo.id;
                    content += "<tr>"+
                    // "<td class=\"unnamed1\"><input type=\"checkbox\" name=\"ids[]\" value=\""+fileinfo.id+"\"></td>"+
                        "<td class=\"unnamed1\">"+fileinfo.dirname+"</td>"+
                        "<td class=\"unnamed1\">"+fileinfo.filename+"</td>"+
                        "<td class=\"unnamed1\">"+fileinfo.url+"</td>"+
                        // "<td class=\"unnamed1\">"+
                        //     "<a href=\""+delurl+"\" onClick=\"return confirm('确定要删除吗? 删除后无法恢复');\">删除</a>"+
                        // "</td>"+
                    "</tr>";
                };
                $('#datatable').html(content);
            }
        }
    });
</script>
