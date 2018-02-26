<?php

namespace app\search;

use app\models\Order;
use app\models\User;
use yii\db\ActiveQuery;

/**
 * Class OrderSearch
 */
class OrderSearch extends BaseSearch
{
    /**
     * @var string type of order
     */
    public $type;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var Order|string
     */
    protected $modelClass = Order::class;

    public function rules()
    {
        return [
            ['type', 'in', 'range' => [Order::TYPE_BUY, Order::TYPE_SELL]],
            ['user_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id']
        ];
    }

    /**
     * @inheritdoc
     */
    protected function onActiveQuery(ActiveQuery $activeQuery)
    {
        $activeQuery->andFilterWhere([
            'type' => $this->type,
            'user_id' => $this->user_id
        ]);
        parent::onActiveQuery($activeQuery);
    }
}