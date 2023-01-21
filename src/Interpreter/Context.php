<?php

namespace InterpretSample\Interpreter;

use InterpretSample\Exceptions\Interpreter\NotFoundExpressionValueException;

/**
 * Контекст интепретации, хранилище данных
 */
class Context
{
    public function __construct()
    {
        $this->errors = new ErrorCollection();
    }

    /**
     * Сохранить значение за выражением
     *
     * @param Expression $expr
     * @param mixed $value
     * @return void
     */
    public function assign(Expression $expr, mixed $value): void
    {
        $this->expressions[$expr->getKey()] = $value;
    }

    /**
     * Получить значение выражения
     *
     * @throws NotFoundExpressionValueException
     *
     * @param Expression $expr
     * @return mixed
     */
    public function lookup(Expression $expr): mixed
    {
        if (isset($this->expressions[$expr->getKey()])) {
            return $this->expressions[$expr->getKey()];
        }

        throw new NotFoundExpressionValueException(
            sprintf('Not found value for expression (class [%s], key [%s])', Expression::class, $expr->getKey())
        );
    }

    /**
     * Получить коллекцию ошибок
     *
     * @return ErrorCollection
     */
    public function errors(): ErrorCollection
    {
        return $this->errors;
    }

    //######################################################################
    // PRIVATE
    //######################################################################

    /** @var array<string, mixed> хранилище значений выражений */
    private array $expressions = [];

    private ErrorCollection $errors;
}
