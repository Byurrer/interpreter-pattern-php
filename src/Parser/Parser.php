<?php

namespace InterpretSample\Parser;

use InterpretSample\Exceptions\Parser\ParserNotFoundException;
use InterpretSample\Exceptions\Parser\PartFailException;
use InterpretSample\Exceptions\Parser\PartFormatException;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\RuleExpression;
use InterpretSample\Interpreter\RulesExpression;
use InterpretSample\ValidationExpression;

/**
 * Парсер строки с правилами
 */
class Parser
{
    public function __construct()
    {
    }

    /**
     * Добавить парсер одного правила
     *
     * @param PartParserAbstract $partParser
     * @return $this
     */
    public function addPartParser(PartParserAbstract $partParser): self
    {
        $this->partParsers[get_class($partParser)] = $partParser;
        return $this;
    }

    /**
     * Получить линейный массив с названиями классов парсеров частиц
     *
     * @return array<string>
     */
    public function getPartParserList(): array
    {
        return array_keys($this->partParsers);
    }

    /**
     * Распарсить строку с правилами
     *
     * @throws PartFormatException
     * @throws ParserNotFoundException
     *
     * @param string $rulesStr
     * @return RulesExpression
     */
    public function parse(string $rulesStr): RulesExpression
    {
        $value = new LiteralExpression();
        $strs = explode('|', trim($rulesStr));

        $rules = [];

        foreach ($strs as $str) {
            $rules[] = $this->partParse(trim($str), $value);
        }

        return new RulesExpression($rules, $value);
    }

    //######################################################################
    // PROTECTED
    //######################################################################

    /** @var array<PartParserAbstract> */
    protected array $partParsers = [];

    //######################################################################

    /**
     * Парсинг части строки перебором различных парсеров
     *
     * @throws PartFormatException
     * @throws ParserNotFoundException
     *
     * @param string $str
     * @param LiteralExpression $value
     * @return RuleExpression
     */
    protected function partParse(string $str, LiteralExpression $value): RuleExpression
    {
        foreach ($this->partParsers as $partParser) {
            try {
                $node = $partParser->genNode($value, $str);
                return $node;
            } catch (PartFailException $e) {
                // не удалось сгенерить ноду, ничего страшного, значит этот парсер не подходит
            } catch (PartFormatException $e) {
                throw $e;
            }
        }

        throw new ParserNotFoundException(sprintf('Not found parser for parsing string [%s]', $str));
    }
}
