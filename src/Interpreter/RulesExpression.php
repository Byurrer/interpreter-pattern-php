<?php

namespace InterpretSample\Interpreter;

use InterpretSample\Exceptions\Interpreter\NotFoundExpressionValueException;

class RulesExpression extends Expression
{
    /**
     * @param array<RuleExpression> $rules
     */
    public function __construct(
        private readonly array $rules,
        public readonly LiteralExpression $value,
    ) {
    }

    /**
     * @throws NotFoundExpressionValueException
     */
    public function evaluate(Context $context): void
    {
        $context->errors()->clear();

        $result = 0;
        foreach ($this->rules as $rule) {
            $rule->evaluate($context);
            if (!$context->lookup($rule)) {
                --$result;
            }
        }
        $context->assign($this, ($result >= 0));
    }
}
