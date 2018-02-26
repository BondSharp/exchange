<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Account
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 * @property double $balance
 * @property double $free
 * @property double $hold
 *
 * @property User $user
 * @property Currency $currency
 */
class Account extends ActiveRecord
{
    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'currency_id',
            'balance',
            'free',
            'hold',
            'code'=>function() {
                return $this->currency->code;
            }
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCurrency(): ActiveQuery
    {
        return $this->hasOne(Currency::class,['id'=>'currency_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() : string
    {
        return 'accounts';
    }
}