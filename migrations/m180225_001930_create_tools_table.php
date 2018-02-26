<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tools`.
 */
class m180225_001930_create_tools_table extends Migration
{
    const TABLE_NAME = 'tools';
    const FK_BASE_CURRENCY = 'fk-tools-base_currency_id';
    const FK_QUOTE_CURRENCY = 'fk-tools-quote_currency_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tools', [
            'id' => $this->primaryKey(),
            'code' => $this->string(7)->notNull(),
            'base_currency_id' => $this->integer()->notNull(),
            'quote_currency_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            self::FK_BASE_CURRENCY,
            self::TABLE_NAME,
            'base_currency_id',
            'currencies',
            'id');

        $this->addForeignKey(
            self::FK_QUOTE_CURRENCY,
            self::TABLE_NAME,
            'quote_currency_id',
            'currencies',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tools');
    }
}
