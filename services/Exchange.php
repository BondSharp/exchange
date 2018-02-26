<?php

namespace app\services;

use app\models\Currency;
use app\models\Tools;
use app\models\User;
use yii\base\Component;
use Yii;

/**
 * Class Exchange
 */
class Exchange
{

    /**
     * @var double
     */
    private $quoteAmount;

    /**
     * @var float
     */
    private $baseAmount;

    /**
     * @var AccountManager
     */
    private $buyerDeposit;

    /**
     * @var AccountManager
     */
    private $buyerWithdraw;

    /**
     * @var AccountManager
     */
    private $sellerDeposit;

    /**
     * @var AccountManager
     */
    private $sellerWithdraw;

    /**
     * Exchange constructor.
     *
     * @param User $buyer
     * @param User $seller
     * @param Tools $tools
     * @param float $amount
     * @param float $rate
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct(User $buyer, User $seller, Tools $tools, float $amount, float $rate)
    {
        $this->buyerDeposit = Yii::createObject(AccountManager::class, [
            'user' => $buyer,
            'currency' => $tools->quoteCurrency
        ]);

        $this->buyerWithdraw = Yii::createObject(AccountManager::class, [
            'user' => $buyer,
            'currency' => $tools->baseCurrency
        ]);

        $this->sellerDeposit = Yii::createObject(AccountManager::class, [
            'user' => $seller,
            'currency' => $tools->baseCurrency
        ]);

        $this->sellerWithdraw = Yii::createObject(AccountManager::class, [
            'user' => $seller,
            'currency' => $tools->quoteCurrency
        ]);

        $this->quoteAmount = $amount;
        $this->baseAmount = $amount / $rate;
    }


    /**
     * @return void
     */
    public function exchange()
    {
        $this->buyerDeposit->deposit($this->quoteAmount);
        $this->buyerWithdraw->withdrawAndUnHold($this->baseAmount);

        $this->sellerDeposit->deposit($this->baseAmount);
        $this->buyerWithdraw->withdrawAndUnHold($this->quoteAmount);
    }


}