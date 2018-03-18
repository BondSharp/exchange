<?php

namespace app\models;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Tools
 *
 * @property  int $id
 * @property  string $code
 * @property  int $base_currency_id
 * @property int $quote_currency_id
 *
 * @property Order[] $orders
 * @property Currency $baseCurrency
 * @property Currency $quoteCurrency
 */
class Tools extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'code'
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields(): array
    {
        return [
            'baseCurrency',
            'quoteCurrency',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['tools_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuoteCurrency(): ActiveQuery
    {
        return $this->hasOne(Currency::class, ['id' => 'quote_currency_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBaseCurrency(): ActiveQuery
    {
        return $this->hasOne(Currency::class, ['id' => 'base_currency_id']);
    }
}