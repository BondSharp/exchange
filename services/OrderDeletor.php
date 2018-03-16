<?php

namespace app\services;


use app\factories\AccountManagerFactory;
use app\models\Order;
use Exception;
use Throwable;
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
     * OrderDeletor constructor.
     *
     * @param Order $order
     * @param AccountManagerFactory $accountManagerFactory
     */
    public function __construct(Order $order)
    {
        $this->accountUnHold = AccountManagerFactory::createByOrder($order)->createWithdrawal();
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