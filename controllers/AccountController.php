<?php

namespace app\controllers;

use app\actions\SearchAction;
use app\search\AccountSearch;

/**
 * Class AccountController
 */
class AccountController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => SearchAction::class,
                'searchClass' => AccountSearch::class
            ]
        ];
    }
}