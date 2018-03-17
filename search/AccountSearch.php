<?php

namespace app\search;

use app\models\Account;
use yii\db\ActiveQuery;

/**
 * Class AccountSearch
 */
class AccountSearch extends BaseSearch
{
    /**
     * @var int[]
     */
    public $id = [];

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => function ($id) {
                if (is_string($id)) {
                    return explode(',', $id);
                }
                return $id;
            }],
            ['id', 'each', 'rule' => ['integer']]
        ];
    }

    /**
     * @var string|Account
     */
    protected $modelClass = Account::class;

    /**
     * @inheritdoc
     */
    protected function onActiveQuery(ActiveQuery $activeQuery)
    {
        if ($this->id) {
            $activeQuery->andWhere(['id' => $this->id]);
        }
        parent::onActiveQuery($activeQuery);
    }

}