<?php


namespace app\factories;


use app\models\Currency;
use app\models\Order;
use app\models\Tools;
use app\models\User;
use app\services\AccountManager;
use phpDocumentor\Reflection\Types\Self_;
use Yii;

/**
 * Class AccountManagerFactory
 */
class AccountManagerFactory
{
    /**
     * @var Tools
     */
    private $tools;
    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    private $isBuyer;

    /**
     * AccountManagerFactory constructor.
     *
     * @param Tools $tools
     * @param User $user
     * @param bool $isBuyer
     */
    public function __construct(Tools $tools, User $user, bool $isBuyer)
    {
        $this->tools = $tools;
        $this->user = $user;
        $this->isBuyer = $isBuyer;
    }

    /**
     * @return AccountManager
     */
    public function createDeposit(): AccountManager
    {
        if ($this->isBuyer) {
            return AccountManager::create($this->user, $this->tools->quoteCurrency);
        }
        return AccountManager::create($this->user, $this->tools->baseCurrency);
    }

    /**
     * @return AccountManager
     */
    public function createWithdrawal(): AccountManager
    {
        if ($this->isBuyer) {
            return $this->createByCurrency($this->tools->baseCurrency);
        }
        return $this->createByCurrency($this->tools->quoteCurrency);
    }

    /**
     * @param Currency $currency
     *
     * @return AccountManager
     */
    private function createByCurrency(Currency $currency): AccountManager
    {
        return AccountManager::create($this->user, $currency);
    }

    /**
     * @param Order $order
     *
     * @return AccountManagerFactory
     */
    public static function createByOrder(Order $order): self
    {
        return new self($order->tools, $order->user, $order->isBuy());
    }

    /**
     * @param Tools $tools
     * @param User $user
     * @param bool $isBuyer
     *
     * @return AccountManagerFactory
     */
    public static function createByTools(Tools $tools, User $user, bool $isBuyer): self
    {
        return new self($tools,$user,$isBuyer);
    }


}