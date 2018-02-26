<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class User
 *
 * @property int $id
 * @property string $email
 *
 *
 * @property Account[] $accounts
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'email',
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'accounts'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAccounts(): ActiveQuery
    {
        return $this->hasMany(Account::class, ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() : string
    {
        return 'users';
    }
}
