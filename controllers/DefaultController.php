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
use yii\web\NotFoundHttpException;
use rabint\page\models\search\PageSearch;

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

        $model->view = ($model->view > 0) ? ($model->view + 1) : 1;
        $model->save(false);
        try {
            return $this->render($model->template, ['model' => $model]);
        } catch (\yii\base\ViewNotFoundException $e) {
            return $this->render('view', ['model' => $model]);
        }
    }
}
