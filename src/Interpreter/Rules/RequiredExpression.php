<?php

namespace InterpretSample\Interpreter\Rules;

use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\RuleExpression;

/**
 * Правило: значение должно быть обязательно !empty()
 */
class RequiredExpression extends RuleExpression
{
    /**
     * @inheritDoc
     */
    public function evaluate(Context $context): void
    {
        if (!($result = !empty($this->value->getValue()))) {
            $this->newError(
                $context,
                new \Exception('value is required, but not value')
            );
        }

        $context->assign($this, $result);
    }
}
