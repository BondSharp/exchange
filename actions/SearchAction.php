<?php

namespace app\actions;

use app\search\BaseSearch;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * Class SearchAction
 */
class SearchAction extends Action
{
    /**
     * @var BaseSearch
     */
    public $searchClass;

    /**
     * @inheritdoc
     */
    public function init()
    {

        if ($this->searchClass === null) {
            throw new InvalidConfigException('The "searchClass" property must be set.');
        }
        parent::init();
    }

    /**
     * @return BaseSearch|ActiveDataProvider
     */
    public function run()
    {
        /**
         * @var BaseSearch $model
         */
        $model = new $this->searchClass();
        $model->load(Yii::$app->request->get(),'');
        if ($model->validate()) {
            return $model->getActiveDataProvider();
        }
        return $model;
    }


}