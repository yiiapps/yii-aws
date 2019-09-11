<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '创建目录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?=Html::encode($this->title);?></h1>
    <div class="row">
        <div class="col-lg-5">
            <div><?=$msg;?></div>
            <?php $form = ActiveForm::begin(['id' => 'createdirform-form']);?>
            <?=$form->field($model, 'name')->textInput(['autofocus' => true]);?>
            <div class="form-group">
                <?=Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'createdirform-button']);?>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
