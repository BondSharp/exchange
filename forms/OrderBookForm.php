<?php

namespace app\forms;

use app\services\OrderBook;
use yii\base\Model;

/**
 * Class OrderBookForm
 */
class OrderBookForm extends Model
{
    /**
     * @var integer
     */
    public $depth;
    /**
     * @var integer id of tools
     */
    public $tools_id;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['depth', 'default', 'value' => 5],
            [['depth', 'tools_id'], 'required'],
            ['depth', 'integer', 'min' => 1, 'max' => 10]
        ];
    }

    /**
     * @return array
     */
    public function getOrderBook(): array
    {
        $model = new OrderBook([
            'tools_id' => $this->tools_id,
            'depth' => $this->depth
        ]);

        return [
            'asks' => array_map('array_values', $model->getAsks()),
            'bids' => array_map('array_values', $model->getBids()),
            'depth' => $model->depth
        ];
    }


}