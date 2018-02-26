<?php

use yii\db\Migration;

/**
 * Handles the creation of table `orders`.
 */
class m180225_011223_create_orders_table extends Migration
{
    const TABLE_NAME = 'orders';
    const FK_USER_NAME = 'fk-order-user_id';
    const FK_TOOLS_NAME = 'fk-order-tools_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'rate' => $this->money(16, 8)->notNull(),
            'amount' => $this->money(16, 8)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'tools_id' => $this->integer()->notNull(),
            'type' => "ENUM('buy', 'sell') NOT NULL",
            'created_at'=>$this->timestamp()->notNull()
        ]);


        $this->addForeignKey(
            self::FK_USER_NAME,
            self::TABLE_NAME,
            'user_id',
            'users',
            'id');

        $this->addForeignKey(
            self::FK_TOOLS_NAME,
            self::TABLE_NAME,
            'tools_id',
            'tools',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::FK_TOOLS_NAME, self::TABLE_NAME);
        $this->dropForeignKey(self::FK_USER_NAME, self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
