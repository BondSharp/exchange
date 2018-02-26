<?php

namespace app\controllers;

use app\actions\SearchAction;
use app\exceptions\HoldFailedException;
use app\models\Order;
use app\search\OrderSearch;
use app\services\OrderDeletor;
use app\services\OrderCreator;
use Exception;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class OrderController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => SearchAction::class,
                'searchClass' => OrderSearch::class
            ]
        ];
    }

    /**
     * @return Order
     *
     * @throws InvalidConfigException
     * @throws HoldFailedException
     */
    public function actionCreate() : Order
    {
        $model = new Order();
        $model->load(Yii::$app->request->post(),'');
        if($model->validate()) {
            Yii::createObject(OrderCreator::class,[$model])->create();
        }
        return $model;
    }

    /**
     * @param int $id
     *
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id) {
        $model = $this->findModel(Order::class,$id);
        Yii::createObject(OrderDeletor::class,[$model])->delete();
    }
}