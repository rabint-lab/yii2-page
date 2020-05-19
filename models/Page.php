<?php

namespace rabint\page\models;

use rabint\behaviors\Slug;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\base\ActiveRecord;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property integer $view
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $template
 * @property string $meta
 */
class Page extends ActiveRecord
{

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public static function templates()
    {
        return [
            'global' => ['title' => \Yii::t('rabint', 'عمومی')],
            'news' => ['title' => \Yii::t('rabint', 'خبر')],
            'report' => ['title' => \Yii::t('rabint', 'گزارش')],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => Slug::class,
                'sourceAttributeName' => 'title',
                'slugAttributeName' => 'slug',
            ],
            //MetaBehavior
            [
                'class' =>  \rabint\behaviors\MetaBehavior::className(),
                'fields' => ['meta_thumbnail', 'meta_summary'],
                'destinationField' => 'meta',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body', 'meta'], 'string'],
            [['status'], 'integer'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 2048],
            [['title'], 'string', 'max' => 512],
            [['view'], 'integer'],
            [['template'], 'string', 'max' => 31],
            [['slug', 'title', 'template', 'body'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['meta_thumbnail', 'meta_summary'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rabint', 'شناسه'),
            'slug' => Yii::t('rabint', 'عنوان مستعار'),
            'title' => Yii::t('rabint', 'عنوان'),
            'body' => Yii::t('rabint', 'متن صفحه'),
            'view' => Yii::t('rabint', 'بازدید'),
            'status' => Yii::t('rabint', 'منتشر شده'),
            'created_at' => Yii::t('rabint', 'Created At'),
            'updated_at' => Yii::t('rabint', 'Updated At'),
            'template' => Yii::t('rabint', 'قالب'),
            'meta' => Yii::t('rabint', 'اطلاعات متا'),
            'meta_thumbnail' => Yii::t('rabint', 'تصویر شاخص'),
            'meta_summary' => Yii::t('rabint', 'خلاصه'),
        ];
    }

    public static function getPageBySlug($slug)
    {
        $page = Page::findOne(['slug' => $slug]);
        if ($page !== null) {
            return $page->body;
        }
        return null;
    }

    public static function getPageById($id)
    {
        $page = Page::findOne($id);
        if ($page !== null) {
            return $page->body;
        }
        return null;
    }

    public static function getPageLinkBySlug($slug)
    {
        return \yii\helpers\Url::to(['/page/view', 'slug' => $slug]);
    }

    public static function getPageLinkById($id)
    {
        $page = Page::findOne($id);
        if ($page !== null) {
            return \yii\helpers\Url::to(['/page/view', 'slug' => $page->slug]);
        }
        return '#';
    }
    public function getExcerpt()
    {
        return (!empty($this->meta_summary)) ? $this->meta_summary : (\rabint\helpers\str::htmlToText(\rabint\helpers\str::summarizeWords($this->body, 20, '...')));
    }
}
