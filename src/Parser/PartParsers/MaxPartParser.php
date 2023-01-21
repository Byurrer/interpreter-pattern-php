<?php

namespace InterpretSample\Parser\PartParsers;

use InterpretSample\Exceptions\Parser\PartFailException;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\RuleExpression;
use InterpretSample\Interpreter\Rules\MaxExpression;
use InterpretSample\Parser\PartParserAbstract;

class MaxPartParser extends PartParserAbstract
{
    public function genNode(LiteralExpression $value, string $str): RuleExpression
    {
        if (preg_match('/max\:(\d+)/i', $str, $match)) {
            return new MaxExpression($value, new LiteralExpression($match[1]));
        }

        throw new PartFailException('string does not match regex /max\:(\d+)/');
    }
}
