<?php

namespace InterpretSample\Parser;

use InterpretSample\Exceptions\Parser\PartFailException;
use InterpretSample\Exceptions\Parser\PartFormatException;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\RuleExpression;

/**
 * Парсер одного правила
 */
abstract class PartParserAbstract
{
    /**
     * Распарсить строку с правилом
     *
     * @throws PartFailException
     * @throws PartFormatException
     *
     * @param LiteralExpression $value
     * @param string $str
     * @return RuleExpression
     */
    abstract public function genNode(LiteralExpression $value, string $str): RuleExpression;
}
