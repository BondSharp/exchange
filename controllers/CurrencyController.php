<?php

namespace app\controllers;

use app\actions\SearchAction;
use app\search\CurrencySearch;

/**
 * Class CurrencyControllers
 */
class CurrencyController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => SearchAction::class,
                'searchClass' => CurrencySearch::class
            ]
        ];
    }
}