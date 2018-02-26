<?php

namespace app\models;

use Webmozart\Assert\Assert;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Order
 *
 * @property int $id
 * @property float $rate
 * @property float $amount
 * @property int $user_id
 * @property int $tools_id
 * @property string $type
 * @property string $created_at
 *
 * @property float $hold
 * @property Currency $holdCurrency
 *
 * @property  Tools $tools
 * @property User $user
 */
class Order extends ActiveRecord
{
    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    const MONEY_PATTERN = '#^\d{1,8}(\.\d{1,8})?$#';

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id',
            'rate',
            'amount',
            'user_id',
            'tools_id',
            'type'

        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields() : array
    {
        return [
            'tools'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['rate', 'amount', 'user_id', 'tools_id', 'type'], 'required'],
            ['type', 'in', 'range' => [self::TYPE_SELL, self::TYPE_BUY]],
            ['user_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            ['tools_id', 'exist', 'targetClass' => Tools::class, 'targetAttribute' => 'id'],
            [['rate', 'amount'], 'number', 'numberPattern' => self::MONEY_PATTERN, 'min' => 0.00001],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveRecord
     */
    public function getTools(): ActiveQuery
    {
        return $this->hasOne(Tools::class, ['id' => 'tools_id']);
    }

    /**
     * @return bool
     */
    public function isBuy(): bool
    {
        return self::TYPE_BUY == $this->type;
    }

    /**
     * @return bool
     */
    public function isSell(): bool
    {
        return self::TYPE_SELL == $this->type;
    }

    /**
     * @return float
     */
    public function getHold(): float
    {
        if ($this->isBuy()) {
            return $this->amount / $this->rate;
        }
        if ($this->isSell()) {
            return $this->amount;
        }
    }

    /**
     * @return Currency
     */
    public function getHoldCurrency(): Currency
    {
        if ($this->isBuy()) {
            return $this->tools->baseCurrency;
        }
        if ($this->isSell()) {
            return $this->tools->quoteCurrency;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }


}