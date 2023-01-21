<?php

namespace tests\Cases;

use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\Rules\IntExpression;
use InterpretSample\Interpreter\Rules\MaxExpression;
use InterpretSample\Interpreter\Rules\MinExpression;
use InterpretSample\Interpreter\Rules\RequiredExpression;
use InterpretSample\Interpreter\RulesExpression;
use PHPUnit\Framework\TestCase;

/**
 * Кейсы построения правил из средств самого интерпретатора
 */
class IterpreterTest extends TestCase
{
    public function testFail(): void
    {
        $context = new Context();
        $value = new LiteralExpression();
        $rules = new RulesExpression(
            [
                new RequiredExpression($value),
                new IntExpression($value),
                new MinExpression($value, new LiteralExpression(1)),
                new MaxExpression($value, new LiteralExpression(100))
            ],
            $value
        );

        $value->setValue(0);
        $rules->evaluate($context);

        self::assertSame(false, $context->lookup($rules));
        self::assertIsIterable($context->errors());
        self::assertSame(true, $context->errors()->count() > 0);
        self::assertSame(true, strlen((string)$context->errors()) > 0);
    }

    public function testSuccess(): void
    {
        $context = new Context();
        $value = new LiteralExpression();
        $rules = new RulesExpression(
            [
                new RequiredExpression($value),
                new IntExpression($value),
                new MinExpression($value, new LiteralExpression(1)),
                new MaxExpression($value, new LiteralExpression(100))
            ],
            $value
        );

        $value->setValue(15);
        $rules->evaluate($context);

        self::assertSame(true, $context->lookup($rules));
        self::assertSame(0, $context->errors()->count());
        self::assertSame(0, strlen((string)$context->errors()));
    }
}
