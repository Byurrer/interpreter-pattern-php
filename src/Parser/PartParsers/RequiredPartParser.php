<?php

namespace InterpretSample\Parser\PartParsers;

use InterpretSample\Exceptions\Parser\PartFailException;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\RuleExpression;
use InterpretSample\Parser\PartParserAbstract;
use InterpretSample\Interpreter\Rules\RequiredExpression;

class RequiredPartParser extends PartParserAbstract
{
    public function genNode(LiteralExpression $value, string $str): RuleExpression
    {
        if (strtolower($str) === 'required') {
            return new RequiredExpression($value);
        }

        throw new PartFailException('not found [required]');
    }
}
