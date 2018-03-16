<?php

namespace app\services;

use app\exceptions\HoldFailedException;
use app\models\Account;
use app\models\Currency;
use app\models\User;
use Yii;

/**
 * Class AccountManager
 */
class AccountManager
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * AccountManager constructor.
     *
     * @param User $user
     * @param Currency $currency
     */
    public function __construct(User $user, Currency $currency)
    {
        $this->user = $user;
        $this->currency = $currency;
    }

    /**
     * @param User $user
     * @param Currency $currency
     *
     * @return AccountManager
     */
    public static function create(User $user, Currency $currency) : self
    {
        return Yii::createObject(self::class, [$user, $currency]);
    }

    /**
     *
     * @return void
     */
    public function deposit(float $amount)
    {
        $this->updateCounters(
            [
                'balance' => $amount,
                'free' => $amount
            ]
        );
    }

    /**
     * @param float $amount
     *
     * @return void
     */
    public function withdrawAndUnHold(float $amount)
    {
        $this->updateCounters(
            [
                'balance' => -$amount,
                'free' => -$amount,
                'hold' => -$amount
            ]
        );
    }

    /**
     * @param float $amount
     *
     * @return void
     *
     * @throws HoldFailedException
     */
    public function holdOrFail(float $amount)
    {

        $fail = !$this->updateCounters(
            [
                'free' => -$amount,
                'hold' => $amount
            ],
            [['>=', 'free', $amount]]

        );
        if ($fail) {
            throw new HoldFailedException();
        }
    }

    /**
     * @param float $amount
     *
     * @return void
     */
    public function unHold(float $amount)
    {
        $this->updateCounters(
            [
                'free' => $amount,
                'hold' => -$amount
            ]
        );
    }

    /**
     * @param array $counters
     * @param array $condition
     *
     * @return int
     */
    private function updateCounters(array $counters, array $condition = []): int
    {
        $condition = array_merge([
            'AND',
            ['=', 'user_id', $this->user->id],
            ['=', 'currency_id', $this->currency->id]
        ], $condition);

        return Account::updateAllCounters($counters, $condition);
    }


}