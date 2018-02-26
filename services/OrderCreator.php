<?php

namespace app\services;


use app\exceptions\HoldFailedException;
use app\models\Order;
use Exception;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Expression;
use yii\db\StaleObjectException;

/**
 * Class OrderCreator
 */
class OrderCreator
{
    /**
     * @var Order
     */
    private $order;
    /**
     * @var MarketExchange
     */
    private $marketExchange;

    /**
     * @var AccountManager
     */
    private $accountHold;

    /**
     * OrderCreator constructor.
     *
     * @param Order $order
     *
     * @throws InvalidConfigException
     */
    public function __construct(Order $order)
    {

        $this->marketExchange = Yii::createObject(MarketExchange::class, [$order]);

        $this->accountHold = Yii::createObject(AccountManager::class, [$order->user, $order->holdCurrency]);

        $this->order = $order;
    }

    /**
     *
     * @return void
     *
     * @throws HoldFailedException
     * @throws InvalidConfigException
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function create()
    {
        $this->accountHold->holdOrFail($this->order->hold);
        $this->marketExchange->exchange();
        if ($this->order->amount) {
            $this->order->created_at = new Expression('NOW()');
            $this->order->save(false);
        }
    }


}