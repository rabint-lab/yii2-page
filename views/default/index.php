<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rabint', 'برگه ها');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spacer"></div>
<div class="spacer"></div>
<div class="list_box page-index">
    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'row news-list'],
        'itemOptions' => ['class' => 'col-sm-12 col-xs-12 col-md-4 news-item'],
        'layout' => "{items}\n<div class=\"clearfix\"></div><div class=\"text-center\">{pager}</div>",
        'pager' => [
            //                        'firstPageLabel' => 'first',
            //                        'lastPageLabel' => 'last',
            //                        'prevPageLabel' => 'previous',
            //                        'nextPageLabel' => 'next',
            //                        'maxButtonCount' => 3,

            // Customzing options for pager container tag
            'options' => [
                'tag' => 'ul',
                'class' => 'col-sm-12 pagination justify-content-center',
                'id' => 'pager-container',
            ],
            // Customzing CSS class for pager link
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'page-item active',
            'disabledPageCssClass' => 'page-link disabled',

            // Customzing CSS class for navigating link
            //                        'prevPageCssClass' => 'page-link',
            //                        'nextPageCssClass' => 'page-link',
            //                        'firstPageCssClass' => 'page-link',
            //                        'lastPageCssClass' => 'page-link',
        ],
        'itemView' => function ($model, $key, $index, $widget) {
            /* @var $model app\modules\post\models\Post */
            $link = Url::to(['/page/default/view', 'slug' => $model->slug]);
            $thumb = \rabint\attachment\models\Attachment::getUrlByPath(
                $model->meta_thumbnail,
                'medium',
                '/img/default/m.jpg'
            );

            $thumb = empty($thumb)?'/img/default/m.jpg':$thumb;
            
            ob_start(); ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="<?= $link; ?>">
                        <?= $model->title; ?>
                    </a>
                </h5>
            </div>


            <div class="item-card-img align-items-center">
                <img src="<?= $thumb; ?>" alt="<?= Html::decode($model->title) ?>">
            </div>

            <p class="card-text new-excerpt"><?= $model->excerpt;?></p>

            <a href="<?= $model->url ?? "#"; ?>" style="padding:10px;" class="card-link" target="_blank"><?= \Yii::t("app", "مشاهده"); ?></a>
        </div>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <?php return ob_get_clean();
    },
]);
?>
<div class="spacer"></div>
<div class="spacer"></div>
</div>