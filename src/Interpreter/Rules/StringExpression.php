<?php

namespace InterpretSample\Interpreter\Rules;

use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\RuleExpression;

/**
 * Правило: ожидается тип значения строковый
 */
class StringExpression extends RuleExpression
{
    /**
     * @inheritDoc
     */
    public function evaluate(Context $context): void
    {
        $value = $this->value->getValue();
        if (!($result = is_string($value))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected string type, but got [%s]', gettype($value)))
            );
        }
        $context->assign($this, $result);
    }
}
