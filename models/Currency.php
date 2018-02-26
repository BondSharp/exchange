<?php

namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class Currency
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 */
class Currency extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        return [
            'id',
            'name',
            'code',
            'currency'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'currencies';
    }
}