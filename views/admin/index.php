<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rabint', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        echo Html::a(Yii::t('rabint', 'Create {modelClass}', [
                    'modelClass' => Yii::t('rabint', 'Page'),
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            'slug',
            [
                'class' =>\rabint\components\grid\EnumColumn::className(),
                'attribute' => 'status',
                'label' => \Yii::t('rabint', 'وضعیت'),
                'enum' => [
                    Yii::t('rabint', 'منتشر نشده'),
                    Yii::t('rabint', 'منتشر شده'),
                ],
            ],
            'slug',
            [
                'class' =>\rabint\components\grid\EnumColumn::className(),
                'attribute' => 'template',
                'enum' =>\yii\helpers\ArrayHelper::getColumn(\rabint\page\models\Page::templates(),'title'),
            ],
            'view',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{appView} {update} {delete}',
                'buttons' => [
                    'appView' => function ($url, $model) {
                        $url =rabint\helpers\uri::toApp('app',['/page/default/view', 'slug' => $model->slug]);
                        return Html::a('<span class="fas fa-eye"></span>', $url, [
                                    'title' => Yii::t('rabint', 'نمایش در سایت'), 'target' => '_BLANK']);
                    },
                        ],
                    ],
                ],
            ]);
            ?>

</div>
