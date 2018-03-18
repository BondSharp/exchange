<?php

namespace app\services;


use app\models\Order;
use app\models\Tools;
use yii\base\Component;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\BatchQueryResult;

/**
 * Class CounterOrders- Gets orders arranged by best price
 *
 */
class CounterOrders
{
    /**
     * @var Order
     */
    private $order;

    /**
     * CounterOrders constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    /**
     * @param string $type type of order
     * @param string $filterRete filter for rate of order
     * @param int $rateSort sort by rate of order
     *
     * @return BatchQueryResult
     */
    protected function getBatchQueryResult(string $type, string $filterRate, int $rateSort): BatchQueryResult
    {
        return Order::find()
            ->andWhere(['type' => $type])
            ->andWhere(['tools_id' => $this->order->tools_id])
            ->andWhere([$filterRate, 'rate', $this->order->rate])
            ->orderBy([
                'rate' => $rateSort,
                'id' => SORT_ASC
            ])->each();
    }


    /**
     * @return BatchQueryResult|Order[]
     *
     * @throws Exception
     */
    public function getCounterOrders(): BatchQueryResult
    {
        switch ($this->order->type) {
            case Order::TYPE_SELL:
                return $this->getBatchQueryResult(Order::TYPE_BUY, '<=', SORT_ASC);
            case Order::TYPE_BUY:
                return $this->getBatchQueryResult(Order::TYPE_SELL, '>=', SORT_DESC);
            default :
                throw new Exception('fatal');
        }

    }

}