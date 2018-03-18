<?php
namespace app\commands;

use app\models\Order;
use app\services\OrderDeletor;
use Yii;
use yii\console\Controller;

/**
 * Class OrderController
 */
class OrderController extends Controller
{
    public function actionDeleteAll() : void {

        foreach (Order::find()->all() as $order) {
            Yii::createObject(OrderDeletor::class,[$order])->delete();
        }
    }
}