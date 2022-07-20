<?php

/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:01 PM
 */

namespace rabint\page\controllers;

use Yii;
use rabint\page\models\Page;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use rabint\page\models\search\PageSearch;
use Spatie\SchemaOrg\Schema;

class DefaultController extends \rabint\controllers\DefaultController
{

    public function actionIndex($type = "news")
    {
        $type = "news";

        $searchModel = new PageSearch();
        $params = Yii::$app->request->queryParams;

        $params['PageSearch']['template'] = $type;
        $params['PageSearch']['status'] = Page::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search($params);

        try {
            return $this->render(
                'index-' . $type,
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]
            );
        } catch (\yii\base\ViewNotFoundException $e) {
            return $this->render(
                'index',
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]
            );
        }
    }

    public function actionView($slug)
    {
        $model = Page::find()->where(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED])->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('rabint', 'Page not found'));
        }
      $this->setSeoOfView($model);

        $model->view = ($model->view > 0) ? ($model->view + 1) : 1;
        $model->save(false);
        try {
            return $this->render($model->template, ['model' => $model]);
        } catch (\yii\base\ViewNotFoundException $e) {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * @param $model Page
     */
    public function setSeoOfView($model){
        /**
         * Set Schema
         */
         $url = \rabint\helpers\uri::toApp('app',['/page/default/view', 'slug' => $model->slug]);
         $baseUrl = Url::base(true);
         $lenghBase = strlen($baseUrl);
        $url = substr($url,$lenghBase-1);

        $breadcrumbsListItems = [];
        $link = $baseUrl;
        foreach (explode("/",$url) as $item){
            $link .="/".$item;
            $ob = Schema::itemList();
            $ob->name($item);
            $ob->url($link);
            $breadcrumbsListItems[] = $ob;
        }

        $breadcrumbs = Schema::breadcrumbList();
        $breadcrumbs->itemListElement($breadcrumbsListItems);

        $schema_type = "\Spatie\SchemaOrg\Schema::".$model->seo_schema_type;
        $ob=$schema_type();
        $ob->identifier(Url::canonical());
        $ob->keywords($model->seo_keywords);
        $ob->description($model->seo_description);
        $ob->thumbnailUrl($model->seo_thumbnail_url);
        $ob->image($model->seo_image_url);
        $ob->dateModified(date('Y-m-d',$model->updated_at));
        $ob->dateCreated(date('Y-m-d',$model->created_at));
        $ob->datePublished(date('Y-m-d',$model->created_at));
        $ob->mainContentOfPage($model->seo_description);
        $ob->about($model->seo_description);
        $ob->url(Url::canonical());
        $ob->breadcrumb($breadcrumbs);
        \rabint\seo\services\SeoService::factory()->setSchema($ob);
        /*
         * End Set Schema
         */
        $model->seoMeta;
    }
}
