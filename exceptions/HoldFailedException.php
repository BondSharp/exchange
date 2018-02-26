<?php
namespace app\exceptions;

use Throwable;
use yii\base\UserException;
use yii\web\NotFoundHttpException;

/**
 * Class NotEnoughMoneyException
 */
class HoldFailedException extends UserException
{
    /**
     * NotEnoughMoneyException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     *
     */
    public function __construct(string $message = "Not enough money for the transaction", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}