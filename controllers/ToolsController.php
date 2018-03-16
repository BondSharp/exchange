<?php

namespace app\controllers;

use app\actions\SearchAction;
use app\forms\OrderBookForm;
use app\search\ToolsSearch;

/**
 * Class ToolsController
 */
class ToolsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => SearchAction::class,
                'searchClass' => ToolsSearch::class
            ]
        ];
    }

    /**
     * @param int $id
     *
     * @return OrderBookForm|array
     */
    public function actionOrderBook(int $id)
    {
        $form = new OrderBookForm();
        $form->tools_id = $id;
        if ($form->validate()) {
            return $form->getOrderBook();
        }
        return $form;
    }
}