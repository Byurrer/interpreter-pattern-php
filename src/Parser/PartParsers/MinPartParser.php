<?php

namespace InterpretSample\Parser\PartParsers;

use InterpretSample\Exceptions\Parser\PartFailException;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\RuleExpression;
use InterpretSample\Interpreter\Rules\MinExpression;
use InterpretSample\Parser\PartParserAbstract;

class MinPartParser extends PartParserAbstract
{
    public function genNode(LiteralExpression $value, string $str): RuleExpression
    {
        if (preg_match('/min\:(\d+)/i', $str, $match)) {
            return new MinExpression($value, new LiteralExpression($match[1]));
        }

        throw new PartFailException('string does not match regex /min\:(\d+)/');
    }
}
