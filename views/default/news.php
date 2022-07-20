<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Page
 */
$this->title = $model->title;

//$this->params['breadcrumbs'][] = ['label' => Yii::t('rabint', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$re = '/(<h(\d)([^>]*)>)(.+?)(<\/h\2>)/m';
$re = '/(<h(\d)[^>]*>)(.+?)(<\/h\2>)/m';
$prossed = preg_replace_callback($re, function ($match) {
    static $cnt = 0;
    $cnt++;
    $return = <<<RET
        <span class="sharplink" id="index_{$cnt}"></span>
        {$match[1]}
            <a href="#index_{$cnt}">
                $match[3]
            </a>
        {$match[4]}
RET;
    return $return;
}, $model->body);

?>
<div class="content page_content ">
    <div class="row justify-content-between">
        
        <div class="col col-sm-12 col-md-5 offset-md-1 ">
            <?php

            $thumb = \rabint\attachment\models\Attachment::getUrlByPath(
                $model->meta_thumbnail,
                'medium',
                '/img/default/m.jpg'
            );

            $thumb = empty($thumb) ? '/img/default/m.jpg' : $thumb;

            ?>
            <img src="<?= $thumb; ?>" class="news-thumb" alt="<?= Html::decode($model->title) ?>">
        </div>

        <div class="col col-sm-12 col-md-5">
            <p class="new-item-excerpt-inpage p-news">
                <?= $model->excerpt; ?>
            </p>
        </div>
        <div class="clearfix">

        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="spacer"></div>
            <?php
            $prossed = \rabint\helpers\shortcode::renderShortcode($prossed);
            ?>
            <?php echo $prossed; ?>
            <div class="spacer"></div>
        </div>
    </div>

</div>