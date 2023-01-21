<?php

namespace InterpretSample\Interpreter;

use Countable;
use Exception;
use Iterator;

/**
 * Коллекция ошибок
 * @implements Iterator<Exception>
 */
class ErrorCollection implements Iterator, Countable
{
    /**
     * Очистить коллекцию ошибок
     *
     * @return $this
     */
    public function clear(): self
    {
        $this->errors = [];
        return $this;
    }

    /**
     * Добавить исключение/ошибку
     *
     * @param Exception $e
     * @return $this
     */
    public function add(Exception $e): self
    {
        $this->errors[] = $e;
        return $this;
    }

    /**
     * Получить краткую сводку ошибок в виде строки
     *
     * @return string
     */
    public function summary(): string
    {
        $a = [];
        foreach ($this->errors as $e) {
            $a[] = $e->getMessage();
        }
        return implode('; ', $a);
    }

    public function __toString(): string
    {
        return $this->summary();
    }

    //######################################################################
    // Iterator

    public function current(): \Exception
    {
        return $this->errors[$this->currKey];
    }

    public function key(): int
    {
        return $this->currKey;
    }

    public function next(): void
    {
        ++$this->currKey;
    }

    public function rewind(): void
    {
        $this->currKey = 0;
    }

    public function valid(): bool
    {
        return ($this->currKey >= 0 && $this->currKey < count($this->errors));
    }

    //######################################################################
    // Countable

    public function count(): int
    {
        return count($this->errors);
    }

    //######################################################################
    // PROTECTED
    //######################################################################

    /** @var array<Exception> */
    protected array $errors = [];

    protected int $currKey = 0;
}
