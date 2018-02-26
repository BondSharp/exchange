<?php

namespace app\services;

use app\models\Order;
use app\models\Tools;
use app\models\User;
use Exception;
use Throwable;
use yii\base\Component;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;

/**
 * Class MarketExchange
 */
class MarketExchange
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var CounterOrders
     */
    private $counterOrders;

    /**
     * MarketExchange constructor.
     *
     * @param Order $order
     *
     * @throws InvalidConfigException
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->counterOrders = Yii::createObject(CounterOrders::class, [$this->order]);
    }

    /**
     * @return void
     *
     * @throws Exception
     * @throws InvalidConfigException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function exchange()
    {
        foreach ($this->counterOrders->getCounterOrders() as $counterOrder) {
            $amount = min($counterOrder->amount, $this->order->amount);
            if ($amount) {
                $this->onExchange($counterOrder, $amount);
                $this->minusAmount($counterOrder, $amount);
                continue;
            }
            break;
        }
    }

    /**
     * @param Order $counterOrder
     * @param float $amount
     *
     * @return void
     *
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
     */
    private function minusAmount(Order $counterOrder, float $amount)
    {
        $this->order->amount -= $amount;
        $counterOrder->amount -= $amount;
        if (!$counterOrder->amount) {
            $counterOrder->delete();
        }
    }


    /**
     * @param Order $counter
     * @param  string $type type of order
     *
     * @return User
     */
    private function getUser(Order $counter, string $type): User
    {
        if ($counter->type == $type) {
            return $counter->user;
        }
        if ($this->order->type == $type) {
            return $this->order->user;
        }

    }

    /**
     * @param Order $counterOrder
     * @param float $amount
     *
     * @return  void
     *
     * @throws InvalidConfigException
     */
    private function onExchange(Order $counterOrder, float $amount)
    {
        $seller = $this->getUser($counterOrder, Order::TYPE_SELL);
        $buyer = $this->getUser($counterOrder, Order::TYPE_BUY);
        $exchange = Yii::createObject(Exchange::class, [
            $buyer, $seller, $this->order->tools, $amount, $counterOrder->rate
        ]);
        $exchange->exchange();
    }

}