<?php

use yii\db\Migration;

/**
 * Class m180225_001324_fill_currencies_table
 */
class m180225_001324_fill_currencies_table extends Migration
{
    const TABLE_NAME = 'currencies';

    const DATA = [
        ['Bitcoin', 'BTC'],
        ['Bitcoin Cash', 'BCH'],
        ['Eterium', 'ETH'],
        ['Ripple', 'XRP']
    ];

    public function safeUp()
    {
        $this->batchInsert(self::TABLE_NAME,['name','code'],self::DATA);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_NAME);
    }

}
