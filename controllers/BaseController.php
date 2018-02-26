<?php

namespace app\controllers;

use yii\db\ActiveRecord;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class BaseController
 */
class BaseController extends Controller
{

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }


    /**
     * @param string|ActiveRecord $classModel
     * @param int $id
     * @param string $message
     *
     * @return ActiveRecord
     *
     * @throws NotFoundHttpException
     */
    protected function findModel(string $classModel, int $id, $message = 'Not found the resource'): ActiveRecord
    {
        $model = $classModel::findOne(['id' => $id]);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException($message);
    }
}