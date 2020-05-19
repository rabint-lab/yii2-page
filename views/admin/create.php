<?php
/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = Yii::t('rabint', 'Create {modelClass}', [
    'modelClass' => 'Page',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('rabint', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
