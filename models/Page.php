<?php

namespace rabint\page\models;

use rabint\behaviors\Slug;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\base\ActiveRecord;
use yii\helpers\Url;

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
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $seo_schema_type
 * @property string $seo_video_url
 * @property string $seo_thumbnail_url
 * @property string $seo_image_url
 */
class Page extends ActiveRecord
{

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    const SCHEMA_TYPE_ABOUTPAGE= 'AboutPage';
    const SCHEMA_TYPE_CHECKOUTPAGE= 'CheckoutPage';
    const SCHEMA_TYPE_COLLECTIONPAGE= 'CollectionPage';
    const SCHEMA_TYPE_CONTACTPAGE= 'ContactPage';
    const SCHEMA_TYPE_FAQPAGE= 'FAQPage';
    const SCHEMA_TYPE_ITEMPAGE= 'ItemPage';
    const SCHEMA_TYPE_MEDICALWEBPAGE= 'MedicalWebPage';
    const SCHEMA_TYPE_PROFILEPAGE= 'ProfilePage';
    const SCHEMA_TYPE_QAPAGE= 'QAPage';
    const SCHEMA_TYPE_REALESTATELISTING= 'RealEstateListing';
    const SCHEMA_TYPE_SEARCHRESULTSPAGE= 'SearchResultsPage';

    public static function getSchemaTypes(){
        return [
            self::SCHEMA_TYPE_ABOUTPAGE => ['title'=>Yii::t('rabint','صفحه درباره')],
            self::SCHEMA_TYPE_CHECKOUTPAGE => ['title'=>Yii::t('rabint','صفحه پرداخت')],
            self::SCHEMA_TYPE_COLLECTIONPAGE => ['title'=>Yii::t('rabint','صفحه دسته بندی')],
            self::SCHEMA_TYPE_CONTACTPAGE => ['title'=>Yii::t('rabint','صفحه تماس با ما')],
            self::SCHEMA_TYPE_FAQPAGE => ['title'=>Yii::t('rabint','صفحه سوالات متداول')],
            self::SCHEMA_TYPE_ITEMPAGE => ['title'=>Yii::t('rabint','صفحه موارد')],
            self::SCHEMA_TYPE_MEDICALWEBPAGE => ['title'=>Yii::t('rabint','صفحه وب پزشکی')],
            self::SCHEMA_TYPE_PROFILEPAGE => ['title'=>Yii::t('rabint','صفحه پروفایل')],
            self::SCHEMA_TYPE_QAPAGE => ['title'=>Yii::t('rabint','صفحه پرسش و پاسخ')],
            self::SCHEMA_TYPE_REALESTATELISTING => ['title'=>Yii::t('rabint','لیست املاک و مستغلات')],
            self::SCHEMA_TYPE_SEARCHRESULTSPAGE => ['title'=>Yii::t('rabint','صفحه نتایج جستجو')],
        ];
    }

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
            [
                'class' => \rabint\seo\behaviors\seoMetaBehavior::class,
                'map' => [
                    'title' => 'title',
                ]
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
            //[['slug', 'title', 'template', 'body'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['meta_thumbnail', 'meta_summary'], 'string'],
            [['seo_video_url', 'seo_thumbnail_url','seo_image_url'], 'string', 'max' => 255],
            [['seo_keywords','seo_description','seo_schema_type'], 'string'],
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
            'seo_keywords' => Yii::t('rabint', 'کلمات کلیدی'),
            'seo_schema_type' => Yii::t('rabint', 'نوع صفحه'),
            'seo_description' => Yii::t('rabint', 'توضیحات'),
            'seo_video_url' => Yii::t('rabint', 'لینک ویدئو'),
            'seo_thumbnail_url' => Yii::t('rabint', 'لینک تصویر کوچک'),
            'seo_image_url' => Yii::t('rabint', 'لینک تصویر'),
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
