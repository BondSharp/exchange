<?php

namespace app\search;

use app\models\User;
use yii\db\ActiveQuery;

/**
 * Class UserSearch
 */
class UserSearch extends BaseSearch
{
    /**
     * @var string
     */
    public $email_like;

    /**
     * @var string|User
     */
    protected $modelClass = User::class;

    public function rules()
    {
        return [
            ['email_like', 'string', 'max' => 50]
        ];
    }


    /**
     * @inheritdoc
     */
    protected function onActiveQuery(ActiveQuery $activeQuery)
    {
        $activeQuery->andWhere(['like', 'email', "$this->email_like%", false]);
        parent::onActiveQuery($activeQuery);
    }


}