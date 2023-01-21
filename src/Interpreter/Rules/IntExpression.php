<?php

namespace InterpretSample\Interpreter\Rules;

use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\RuleExpression;

/**
 * Правило: ожидается тип значения integer
 */
class IntExpression extends RuleExpression
{
    /**
     * @inheritDoc
     */
    public function evaluate(Context $context): void
    {
        $value = $this->value->getValue();
        if (!($result = is_int($value))) {
            $this->newError(
                $context,
                new \Exception(sprintf('expected integer type, but got [%s]', gettype($value)))
            );
        }
        $context->assign($this, $result);
    }
}
