<?php

namespace InterpretSample\Interpreter;

/**
 * Абстрактный класс выражения
 */
abstract class Expression
{
    /**
     * Выполнение выражения
     *
     * @param Context $context
     * @return void
     */
    abstract public function evaluate(Context $context): void;

    /**
     * Получить уникальный ключ текущего объекта
     *
     * @return string
     */
    public function getKey(): string
    {
        if (!$this->key) {
            $this->key = (string)(++self::$globalKey);
        }

        return $this->key;
    }

    //######################################################################
    //PROTECTED
    //######################################################################

    protected static int $globalKey = 0;

    protected string $key = '';
}
