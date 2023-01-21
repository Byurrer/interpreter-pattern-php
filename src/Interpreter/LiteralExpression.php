<?php

namespace InterpretSample\Interpreter;

class LiteralExpression extends Expression
{
    /**
     * @param mixed|null $value
     */
    public function __construct(protected mixed $value = null)
    {
    }

    public function evaluate(Context $context): void
    {
        $context->assign($this, $this->value);
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
