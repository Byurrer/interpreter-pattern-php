<?php

namespace InterpretSample\Parser\PartParsers;

use InterpretSample\Exceptions\Parser\PartFailException;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\RuleExpression;
use InterpretSample\Interpreter\Rules\IntExpression;
use InterpretSample\Interpreter\Rules\StringExpression;
use InterpretSample\Parser\PartParserAbstract;

class TypePartParser extends PartParserAbstract
{
    public function genNode(LiteralExpression $value, string $str): RuleExpression
    {
        $a = [
            IntExpression::class => [
                'int', 'integer'
            ],
            StringExpression::class => [
                'str', 'string'
            ]
        ];

        foreach ($a as $cls => $values) {
            if (in_array($str, $values)) {
                return new $cls($value);
            }
        }

        throw new PartFailException('not found type');
    }
}
