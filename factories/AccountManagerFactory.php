<?php


namespace app\factories;


use app\models\Currency;
use app\models\Order;
use app\models\Tools;
use app\models\User;
use app\services\AccountManager;
use Yii;
class AccountManagerFactory
{
    /**
     * @param Tools $tools
     * @param User $user
     * @param bool $isBuyer
     * @param bool $in if true need the account for deposit else withdraw
     *
     * @return bool
     */
    public function createByTools(Tools $tools, User $user, bool $isBuyer, bool $in): AccountManager
    {
        $currency = $this->getCurrency($tools,$isBuyer,$in);
        return Yii::createObject(AccountManager::class,[$user,$currency]);
    }

    /**
     * @param Order $order
     * @param bool $in if true need the account for deposit else withdraw
     *
     * @return AccountManager
     */
    public function createByOrder(Order $order, bool $in): AccountManager
    {
        return $this->createByTools($order->tools, $order->user, $order->isBuy(),$in);
    }


    private function getCurrency(Tools $tools, bool $isBuyer, bool $in) :  Currency
    {
        if (($isBuyer && $in) || (!$isBuyer && !$in)) {
            return $tools->quoteCurrency;
        }

        if ((!$isBuyer && $in) || ($isBuyer && !$in)) {
            return $tools->baseCurrency;
        }
    }
}