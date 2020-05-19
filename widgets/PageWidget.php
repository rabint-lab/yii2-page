<?php
/**
 * Created by PhpStorm.
 * User: mojtaba
 * Date: 3/16/19
 * Time: 11:17 AM
 */

namespace rabint\page\widgets;


use rabint\page\models\search\PageSearch;

class PageWidget extends \yii\bootstrap\Widget
{

    var $key = '';
    var $cssClass = '';
    var $page = 1;
    var $count = 5;
    var $title = '';
    var $query = [];
    var $style = 'default';
    var $arcLink = ['/page/default/index'];
    var $orderBy = null;
    /**
     *
     * @var \yii\data\ActiveDataProvider
     */
    var $dataProvider = null;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
//        if (empty($this->key)) {
//            $this->key = md5('a' . $this->page . $this->count . print_r($this->query, true));
//        }
//        $cacheKey = [
//            self::className(),
//            $this->key
//        ];
        if (null === $this->dataProvider) {
            $params = ['PageSearch' => $this->query];
            $dataProvider = (new PageSearch())->search($params);
        } else {
            $dataProvider = $this->dataProvider;
        }
        if (!empty($this->page)) {
            $dataProvider->pagination->page = $this->page - 1;
        }
        if (!empty($this->count)) {
            $dataProvider->pagination->pageSize = $this->count;
        }
        $this->dataProvider = $dataProvider;
//            \Yii::$app->cache->set($cacheKey, $dataProvider, 1200);
//        }
        parent::init();
    }

    public function run()
    {
        return $this->render('PageWidget/' . $this->style, [
            'cssClass' => $this->cssClass,
            'key' => $this->key,
            'title' => $this->title,
            'page' => $this->page,
            'count' => $this->count,
            'arcLink' => $this->arcLink,
            'dataProvider' => $this->dataProvider,
        ]);
    }

}
