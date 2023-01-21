<?php

namespace InterpretSample\Interpreter\Rules;

use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\RuleExpression;

/**
 * Абстрактный класс выражений основанный на измерении значения
 */
abstract class MeasurementExpressionAbstract extends RuleExpression
{
    public function __construct(
        protected LiteralExpression $value,
        protected LiteralExpression $literal
    ) {
    }

    /**
     * @inheritDoc
     */
    public function evaluate(Context $context): void
    {
        $value = $this->value->getValue();
        if (is_numeric($value)) {
            if (is_double($value)) {
                $this->doEvaluateFloat($context);
            } else {
                $this->doEvaluateInt($context);
            }
        } elseif (is_string($value)) {
            $this->doEvaluateString($context);
        } else {
            $this->newError(
                $context,
                new \Exception('expected type numeric or string, but got ' . gettype($this->value->getValue()))
            );
        }
    }

    //######################################################################
    // PROTECTED
    //######################################################################

    /**
     * Выполнение выражения в случае если значение целочисленное
     *
     * @param Context $context
     * @return void
     */
    abstract protected function doEvaluateInt(Context $context): void;

    /**
     * Выполнение выражения в случае если значение с плавающей запятой
     *
     * @param Context $context
     * @return void
     */
    abstract protected function doEvaluateFloat(Context $context): void;

    /**
     * Выполнение выражения в случае если значение строковое
     *
     * @param Context $context
     * @return void
     */
    abstract protected function doEvaluateString(Context $context): void;
}
