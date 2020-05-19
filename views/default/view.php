<?php
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
<div class="content page_content">
    <?php echo $prossed; ?>
</div>