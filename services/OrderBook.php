<?php

namespace app\services;

use app\models\Order;
use app\models\queries\BaseQuery;
use yii\base\Component;
use yii\db\Query;

/**
 * Class OrderBook - Order book trading
 */
class OrderBook extends Component
{
    /**
     * @var int
     */
    public $tools_id;
    /**
     * @var $depth
     */
    public $depth;

    /**
     * @return Query
     */
    private function getQueryOffers(): Query
    {
        return (new Query())
            ->from(Order::tableName())
            ->andWhere(['tools_id' => $this->tools_id])
            ->groupBy('rate')
            ->select(['rate', 'amount' => 'sum(amount)'])
            ->limit($this->depth);
    }

    /**
     * @return array
     */
    public function getBids(): array
    {
        return $this->getQueryOffers()
            ->andWhere(['type'=>Order::TYPE_BUY])
            ->orderBy(['rate'=>SORT_ASC])
            ->all();
    }

    /**
     * @return array
     */
    public function getAsks(): array
    {
        return $this->getQueryOffers()
            ->andWhere(['type'=>Order::TYPE_SELL])
            ->orderBy(['rate'=>SORT_DESC])
            ->all();
    }


}