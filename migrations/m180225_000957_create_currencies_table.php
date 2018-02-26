<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currencies`.
 */
class m180225_000957_create_currencies_table extends Migration
{
    const TABLE_NAME = 'currencies';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string(3)->notNull()
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
