<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m180225_003201_fill_tools_table
 */
class m180225_003201_fill_tools_table extends Migration
{

    const TABLE_NAME = 'tools';

    const DATA = [
        ['BTC', 'BCH'],
        ['BTC', 'ETH'],
        ['BTC', 'XRP'],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (self::DATA as list($base_code, $quote_code)) {
            $code = implode('_', [$base_code, $quote_code]);
            $this->insert(self::TABLE_NAME, [
                'code' => $code,
                'quote_currency_id' => $this->getCurrencyId($quote_code),
                'base_currency_id' => $this->getCurrencyId($base_code)
            ]);
        }
    }

    /**
     * @param string $code
     *
     * @return int
     *
     * @throws Exception
     */
    private function getCurrencyId(string $code): int
    {
        $result = (new Query())->from('currencies')->andWhere(['code'=> $code])->one($this->db);
        if ($result) {
            return $result['id'];
        }
        throw new Exception('Not found currency');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_NAME);
    }

}
