<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\PageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'slug') ?>

    <?php echo $form->field($model, 'title') ?>

    <?php echo $form->field($model, 'body') ?>

    <?php echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('rabint', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('rabint', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
