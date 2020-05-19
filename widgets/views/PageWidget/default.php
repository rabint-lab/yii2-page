<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php

//$dependency = [
//    'class' => 'yii\caching\DbDependency',
//    'sql' => 'SELECT MAX(updated_at) FROM `pst_post` where status = 4',
//];

//if ($this->beginCache($key, ['dependency' => $dependency,'duration' => config('GLOBAL_CACHE_TIME', 1200)])) {
?>
<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'layout' => '{items}',
    'itemView' => function ($model, $key, $index, $widget) {
        $link = \rabint\helpers\uri::to(['/page/default/view', 'slug' => $model->slug]);
        ob_start();
        ?>
        <div class="new-item">
            <h6 class="new-item-title">
                <?= Html::a($model->title, $link, ['title' => Html::encode($model->title)]); ?>
            </h6>
            <p class="new-item-excerpt">
                <?= $model->excerpt; ?>
            </p>
            <div class="clearfix"></div>
            <hr/>
        </div>
        <div class="clearfix"></div>

        <?php
        return ob_get_clean();
    },
]);
//$this->endCache();
//}