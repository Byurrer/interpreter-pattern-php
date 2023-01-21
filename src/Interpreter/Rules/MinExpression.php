<?php

namespace InterpretSample\Interpreter\Rules;

use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\LiteralExpression;

/**
 * Правило: минимальное числовое значение или минимальная длина строки
 */
class MinExpression extends MeasurementExpressionAbstract
{
    /**
     * @inheritDoc
     */
    protected function doEvaluateInt(Context $context): void
    {
        $curr = intval($this->value->getValue());
        $expected = intval($this->literal->getValue());
        if (!($result = ($curr >= $expected))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected min range %d, but got %d', $expected, $curr))
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
        if (!($result = ($curr >= $expected))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected min range %f, but got %f', $expected, $curr))
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
        if (!($result = ($curr >= $expected))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected min length %d, but got string length %d', $expected, $curr))
            );
        }
        $context->assign($this, $result);
    }
}
