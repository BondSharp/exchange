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
    public $user_id = [];

    public function rules()
    {
        return [
            [['id', 'user_id'], 'filter', 'filter' => function ($value) {
                if (is_string($value)) {
                    return explode(',', $value);
                }
                return $value;
            }],
            [['id', 'user_id'], 'each', 'rule' => ['integer']]
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
        if ($this->user_id) {
            $activeQuery->andWhere(['user_id' => $this->user_id]);
        }
        parent::onActiveQuery($activeQuery);
    }

}