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
     * @param string $filterRate filter for rate of order
     * @param int $rateSort sort by rate of order
     *
     * @return void
     *
     * @throws Exception
     */
    private function getCriteria(&$type, &$filterRate, &$rateSort)
    {
        switch ($this->order->type) {
            case Order::TYPE_SELL:
                $type = Order::TYPE_BUY;
                $filterRate = '<=';
                $rateSort = SORT_ASC;
                break;
            case Order::TYPE_BUY:
                $type = Order::TYPE_SELL;
                $filterRate = '<=';
                $rateSort = SORT_DESC;
                break;
            default :
                throw new Exception('fatal');
        }

    }


    /**
     * @return BatchQueryResult|Order[]
     * @throws Exception
     */
    public function getCounterOrders(): BatchQueryResult
    {
        $this->getCriteria($type, $filterRete, $rateSort);

        return Order::find()
            ->andWhere(['type' => $type])
            ->andWhere(['tools_id' => $this->order->tools_id])
            ->andWhere([$filterRete, 'rate', $this->order->rate])
            ->orderBy([
                'rate' => $rateSort,
                'id' => SORT_ASC
            ])->each();
    }

}