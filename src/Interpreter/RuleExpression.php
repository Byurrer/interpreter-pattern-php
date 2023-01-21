<?php

namespace InterpretSample\Interpreter;

abstract class RuleExpression extends Expression
{
    public function __construct(protected LiteralExpression $value)
    {
    }

    //######################################################################
    // PROTECTED
    //######################################################################

    protected function newError(Context $context, \Exception $e): self
    {
        $context->errors()->add($e);
        return $this;
    }
}
