<?php

use yii\db\Migration;

/**
 * Handles the creation of table `accounts`.
 */
class m180225_004741_create_accounts_table extends Migration
{
    const TABLE_NAME = 'accounts';

    const FK_USER_NAME = 'fk-account-user_id';
    const FK_CURRENCY_NAME = 'fk-account-currency_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('accounts', [
            'id' => $this->primaryKey(),
            'balance' => $this->money(16, 8)->notNull()->defaultValue(0),
            'free' => $this->money(16, 8)->notNull()->defaultValue(0),
            'hold' => $this->money(16, 8)->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull(),
            'currency_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            self::FK_CURRENCY_NAME,
            self::TABLE_NAME,
            'currency_id',
            'currencies',
            'id');

        $this->addForeignKey(
            self::FK_USER_NAME,
            self::TABLE_NAME,
            'user_id',
            'users',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::FK_USER_NAME, self::TABLE_NAME);
        $this->dropForeignKey(self::FK_USER_NAME, self::TABLE_NAME);
        $this->dropTable('accounts');
    }
}
