<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180225_000310_create_users_table extends Migration
{
    const TABLE_NAME = 'users';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'email' => $this->string(50)->unique()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
