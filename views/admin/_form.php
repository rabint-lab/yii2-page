<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\bootstrap\ActiveForm */
$this->context->layout = "@themeLayouts/full";
?>
<?php $form = ActiveForm::begin(); ?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-8">
        <div class="card block block-rounded">
            <div class="card-header block-header block-header-default ">
                <h3 class="block-title"><?= Yii::t('rabint', 'محتوا'); ?></h3>
            </div>

            <div class="card-body block-content block-content-full">
                <div class="page-form">
                    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                    
                    <?php echo $form->field($model, 'meta_summary')->textarea(['maxlength' => true]) ?>

                    <?= \rabint\helpers\widget::wysiwyg($form, $model, 'body', [], [
                        'options' => [
                            'minHeight' => 500,
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card block block-rounded">
                    <div class="card-header block-header block-header-default ">
                        <h3 class="block-title"><?= Yii::t('rabint', 'انتشار'); ?></h3>
                    </div>
                    <div class="card-body block-content block-content-full">
                        <?php echo $form->field($model,
                            'template')->dropDownList(\yii\helpers\ArrayHelper::getColumn(\rabint\page\models\Page::templates(),
                            'title')); ?>
                        <?php echo $form->field($model, 'status')->checkbox(['class' => 'flat-blue']); ?>
                    </div>
                    <div class="card-footer block-content block-content-full bg-gray-light">
                        <div class="pull-left float-left">
                            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('rabint',
                                'Create') : Yii::t('rabint', 'Update'),
                                ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
                        </div>
                    </div><!-- /.box-footer-->
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card block block-rounded">
                    <div class="card-header block-header block-header-default">
                        <h3 class="box-title"><?= Yii::t('rabint', 'تصویر شاخص'); ?></h3>
                        
                    </div>
                    <div class="card-body block-content block-content-full">
                        <?php
                            echo \rabint\helpers\widget::uploader($form,$model,'meta_thumbnail',['returnType' => 'path']);
                        ?>
                    </div>
                </div>
            </div>
            <?php if(!$model->isNewRecord) {?>
            <div class="col-sm-12">
                <div class="card block block-rounded">
                    <div class="card-header block-header block-header-default ">
                        <h3 class="block-title"><?= Yii::t('rabint', 'آمار'); ?></h3>
                        
                    </div><!-- /.box-header -->
                    <div class="card-body block-content block-content-full">
                        <ul class="nav nav-stacked">
                            <li>
                                <a href="#">
                                    <?= Yii::t('rabint', 'تعداد بازدید'); ?> :
                                    <span class="pull-left float-left badge bg-blue"><?= intval($model->view); ?></span>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div><!-- /.card-body block-content block-content-full -->
                </div><!-- /.box -->
            </div>
            <?php }?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="clearfix"></div>
