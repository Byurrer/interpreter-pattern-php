<?php

namespace InterpretSample\Interpreter\Rules;

use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\LiteralExpression;

/**
 * Правило: максимальное числовое значение или максимальная длина строки
 */
class MaxExpression extends MeasurementExpressionAbstract
{
    /**
     * @inheritDoc
     */
    protected function doEvaluateInt(Context $context): void
    {
        $curr = intval($this->value->getValue());
        $expected = intval($this->literal->getValue());
        if (!($result = ($curr <= $expected))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected max range %d, but got %d', $expected, $curr))
            );
        }
        $context->assign($this, $result);
    }

    /**
     * @inheritDoc
     */
    protected function doEvaluateFloat(Context $context): void
    {
        $curr = floatval($this->value->getValue());
        $expected = floatval($this->literal->getValue());
        if (!($result = ($curr <= $expected))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected max range %f, but got %f', $expected, $curr))
            );
        }
        $context->assign($this, $result);
    }

    /**
     * @inheritDoc
     */
    protected function doEvaluateString(Context $context): void
    {
        $curr = strlen(strval($this->value->getValue()));
        $expected = intval($this->literal->getValue());
        if (!($result = ($curr <= $expected))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected max length %d, but got string length %d', $expected, $curr))
            );
        }
        $context->assign($this, $result);
    }
}
