<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = Yii::t('rabint', 'Update {modelClass}: ', [
    'modelClass' =>  Yii::t('rabint','Page'),
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rabint', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('rabint', 'Update');
?>
<div class="page-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
