<?php

namespace app\controllers;

use app\actions\SearchAction;
use app\forms\UserNewForm;
use app\search\UserSearch;
use yii\rest\Controller;
use Yii;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => SearchAction::class,
                'searchClass' => UserSearch::class
            ]
        ];
    }

    public function actionCreate()
    {
        $model = new UserNewForm();
        $model->load(Yii::$app->request->post());
        if ($user = $model->register()) {
            return $user;
        }
        return $model;
    }
}