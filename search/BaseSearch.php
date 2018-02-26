<?php

namespace app\search;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class BaseSearch
 */
class BaseSearch extends Model
{
    /**
     * @var int
     */
    protected $perPage = 20;

    /**
     * @var ActiveRecord|string
     */
    protected $modelClass;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException('The "modelClass" property must be set.');
        }
        parent::init();
    }

    /**
     * @return ActiveQuery
     */
    public function getActiveQuery(): ActiveQuery
    {
        $activeQuery = $this->modelClass::find();
        $this->onActiveQuery($activeQuery);
        return $activeQuery;
    }

    /**
     * @param ActiveQuery $activeQuery
     *
     * @return void
     */
    protected function onActiveQuery(ActiveQuery $activeQuery)
    {
    }

    /**
     * @return ActiveDataProvider
     */
    public function getActiveDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $this->getActiveQuery(),
            'pagination' => [
                'pageSize' => $this->perPage,
            ],
        ]);
    }
}