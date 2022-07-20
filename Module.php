<?php

namespace rabint\page;

/**
 * Page module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'rabint\page\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }


    public static function adminMenu()
    {
        return [
            [
                'label' => \Yii::t('rabint', 'مدیریت محتوا'),
                'options' => ['class' => 'nav-main-heading'],
                'visible' =>\rabint\helpers\user::can('manager'),
            ],
            [
                'label' => \Yii::t('rabint', 'صفحات ایستا'),
                'icon' => '<i class="fas fa-file-alt"></i>',
                'url' => '#',
                'visible' =>\rabint\helpers\user::can('manager'),
                'items' => [
                    [
                        'label' => \Yii::t('rabint', 'همه برگه ها'), 'url' => ['/page/admin'], 'icon' => '<i class="far fa-circle"></i>',
                    ],
                    ['label' => \Yii::t('rabint', 'ایجاد برگه جدید'), 'url' => ['/page/admin/create'], 'icon' => '<i class="far fa-circle"></i>'],
                ],
                //                ['label' => \Yii::t('rabint', 'برچسب'), 'url' => ['/post/admin-tag'], 'icon' => '<i class="far fa-circle"></i>'],
                //                ['label' => \Yii::t('rabint', 'گروه ها'), 'url' => ['/post/admin-group'], 'icon' => '<i class="far fa-circle"></i>'],
            ]
        ];
    }
}
