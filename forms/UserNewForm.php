<?php

namespace app\forms;

use app\models\User;
use app\services\UserCreator;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Yii;

/**
 * Class UserNewForm - form registration
 */
class UserNewForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @inheritdoc
     */
    public function formName() : string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
            ['email','unique','targetClass' => User::class],
            ['email', 'string', 'max' => 30],
        ];
    }

    /**
     * @return User|null
     *
     * @throws InvalidConfigException
     */
    public function register(): ?User
    {
        if ($this->validate()) {
            $user = new User([
                'email' => $this->email
            ]);
            $creator = Yii::createObject(UserCreator::class, [$user]);
            $creator->create();
            return $user;
        }
        return null;
    }
}