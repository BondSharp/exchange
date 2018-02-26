<?php

namespace app\services;


use app\models\Order;
use Exception;
use Throwable;
use yii\base\Component;
use Yii;
use yii\db\StaleObjectException;

/**
 * Class OrderDeletor
 */
class OrderDeletor
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var AccountManager
     */
    private $accountUnHold;


    /**
     * @inheritdoc
     */
    public function __construct(Order $order)
    {
        $this->accountUnHold = Yii::createObject(AccountManager::class, [$order->user,$order->holdCurrency]);
        $this->order = $order;
    }

    /**
     * @return void
     *
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function delete()
    {
        $this->order->delete();
        $this->accountUnHold->unHold($this->order->hold);
    }
}