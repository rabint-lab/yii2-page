<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use rabint\helpers\uri;

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
            'options' => ['class' => 'newsWidgetList row'],
            'itemOptions' => ['class' => 'item col'],
            'layout' => '{items}',
            'itemView' => function ($model, $key, $index, $widget) {
                $link = \rabint\helpers\uri::to(['/page/default/view', 'slug' => $model->slug]);
                ob_start();
                ?>
        <div class="new-item">
            <h6 class="new-item-title">
                <?= Html::a($model->title, $link, ['title' => Html::encode($model->title)]); ?>
            </h6>
            <div class="news_img">
                <?php 
                $thumb = \rabint\attachment\models\Attachment::getUrlByPath(
                    $model->meta_thumbnail,
                    'medium',
                    '/img/default/m.jpg'
                );
    
                $thumb = empty($thumb)?'/img/default/m.jpg':$thumb;
                ?>
                <a href="<?=$link;?>">
                    <img src="<?= $thumb; ?>" class="news-thumb" alt="<?= Html::decode($model->title) ?>">
                </a>
            </div>
            <p class="new-item-excerpt">
                <?= $model->excerpt; ?>
            </p>
            <div class="clearfix"></div>
            <hr />
        </div>
        <div class="clearfix"></div>

        <?php
        return ob_get_clean();
    },
]);
//$this->endCache();
//}
?>
<div class="row">
    <div class="col">
        <a href="<?=uri::to($arcLink);?>" class="float-left"><?= \Yii::t('rabint', 'بیشتر');?></a>
    </div>
</div>