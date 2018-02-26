<?php

namespace app\services;

use app\models\Account;
use app\models\Currency;
use app\models\User;
use yii\base\Component;

/**
 * Class UserCreator
 */
class UserCreator
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserCreator constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return void
     */
    public function create()
    {
        $this->user->save(false);
        $this->createAccounts();
    }

    /**
     * @return void
     */
    private function createAccounts()
    {
        foreach (Currency::find()->all() as $currency) {
            $account = new Account([
                'user_id' => $this->user->id,
                'currency_id' => $currency->id
            ]);
            if (YII_DEBUG) {
                $account->balance = $account->free = 1000;
            }
            $account->save(false);
        }
    }
}