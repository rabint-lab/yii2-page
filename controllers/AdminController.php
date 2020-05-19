<?php

namespace rabint\page\controllers;

use rabint\helpers\collection;
use rabint\helpers\str;
use Yii;
use rabint\page\models\Page;
use rabint\page\models\search\PageSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class AdminController extends \rabint\controllers\AdminController
{

    public function behaviors()
    {
        $ret = parent::behaviors();
        return $ret + [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['post'],
                    ],
                ],
            ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', \Yii::t('rabint', 'پیام شما یا موفقیت ثبت شد'));
                return $this->redirect(['index']);
//                return $this->refresh();
            } else {
                $modelErr = str::modelErrToStr($model->errors);
                Yii::$app->session->setFlash('error',
                    \Yii::t('rabint', 'متاسفانه در ارسال پیام خطایی رخ داده است. لطفا دوباره تلاش نمایید.')."<br/>".$modelErr);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
