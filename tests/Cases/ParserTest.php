<?php

namespace tests\Cases;

use InterpretSample\Interpreter\Context;
use InterpretSample\Parser\Parser;
use InterpretSample\Parser\PartParsers\MaxPartParser;
use InterpretSample\Parser\PartParsers\MinPartParser;
use InterpretSample\Parser\PartParsers\RequiredPartParser;
use InterpretSample\Parser\PartParsers\TypePartParser;
use PHPUnit\Framework\TestCase;

/**
 * Кейсы использования интепретатор через парсер
 */
class ParserTest extends TestCase
{
    private static Parser $parser;

    public static function setUpBeforeClass(): void
    {
        self::$parser = new Parser();
        self::$parser
            ->addPartParser(new RequiredPartParser())
            ->addPartParser(new TypePartParser())
            ->addPartParser(new MinPartParser())
            ->addPartParser(new MaxPartParser());
    }

    //######################################################################

    public function testFail1(): void
    {
        $rules = self::$parser->parse('required|string|min:3|max:32');
        $context = new Context();

        $rules->value->setValue(10);
        $rules->evaluate($context);

        self::assertSame(false, $context->lookup($rules));
        self::assertIsIterable($context->errors());
        self::assertSame(true, $context->errors()->count() > 0);
        self::assertSame(true, strlen((string)$context->errors()) > 0);
    }

    public function testOk1(): void
    {
        $rules = self::$parser->parse('required|string|min:3|max:32');
        $context = new Context();

        $rules->value->setValue('asd');
        $rules->evaluate($context);

        self::assertSame(true, $context->lookup($rules));
        self::assertSame(true, $context->errors()->count() == 0);
        self::assertSame(true, strlen((string)$context->errors()) == 0);
    }

    //######################################################################

    public function testFail2(): void
    {
        $rules = self::$parser->parse('required|int|min:0|max:256');
        $context = new Context();

        $rules->value->setValue(-2);
        $rules->evaluate($context);

        self::assertSame(false, $context->lookup($rules));
        self::assertSame(true, $context->errors()->count() > 0);
        self::assertSame(true, strlen((string)$context->errors()) > 0);
    }

    public function testOk2(): void
    {
        $rules = self::$parser->parse('required|int|min:0|max:256');
        $context = new Context();

        $rules->value->setValue(115);
        $rules->evaluate($context);

        self::assertSame(true, $context->lookup($rules));
        self::assertSame(true, $context->errors()->count() == 0);
        self::assertSame(true, strlen((string)$context->errors()) == 0);
    }
}
