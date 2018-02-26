<?php

namespace app\search;

use app\models\Currency;

/**
 * Class CurrencySearch
 */
class CurrencySearch extends BaseSearch
{
    /**
     * @var string|Currency
     */
    protected $modelClass = Currency::class;
}