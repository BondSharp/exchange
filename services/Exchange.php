<?php

namespace app\services;

use app\factories\AccountManagerFactory;
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
     */
    public function __construct(User $buyer, User $seller, Tools $tools, float $amount, float $rate)
    {
        $accountBuyerFactory = AccountManagerFactory::createByTools($tools, $buyer, true);
        $accountSellerFactory = AccountManagerFactory::createByTools($tools, $buyer, true);
        $this->buyerDeposit = $accountBuyerFactory->createDeposit();
        $this->buyerWithdraw = $accountBuyerFactory->createWithdrawal();
        $this->sellerDeposit = $accountSellerFactory->createDeposit();
        $this->sellerWithdraw = $accountSellerFactory->createWithdrawal();

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
        $this->sellerWithdraw->withdrawAndUnHold($this->quoteAmount);
    }


}