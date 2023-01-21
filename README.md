
# Interpreter pattern on PHP (8.1)

Пример реализации шаблона объектно-ориентированного проектирования **Интерпретатор**.

Источником вдохновения послужила [валидация в laravel 8](https://laravel.su/docs/8.x/validation), которую можно было реализовать с помощью этого паттерна.

Кроме самого интепретатора ([Interpreter](/src/Interpreter)), проект содержит парсер ([Parser](/src/Parser)) для преобразования строки в набор выражений интепретатора.

Также в проекте есть тесты ([tests](/tests)) с кейсами использования интепретатора при помощи парсера либо при помощи ручной сборки выражений.

## [РБНФ](https://ru.wikipedia.org/wiki/%D0%A0%D0%B0%D1%81%D1%88%D0%B8%D1%80%D0%B5%D0%BD%D0%BD%D0%B0%D1%8F_%D1%84%D0%BE%D1%80%D0%BC%D0%B0_%D0%91%D1%8D%D0%BA%D1%83%D1%81%D0%B0_%E2%80%94_%D0%9D%D0%B0%D1%83%D1%80%D0%B0)

```
required = 'required'.
type = ('str'|'string')|('int'|'integer').
min = 'min',':',number.
max = 'max',':',number.
expression = required|type|min|max.
rules = expression['|'expression].
```

## Примеры правил

```
required|string|min:3|max:16
```

```
int|max:127
```

## Примеры

### Через парсер
```php
use InterpretSample\Interpreter\Context;
use InterpretSample\Parser\Parser;
use InterpretSample\Parser\PartParsers\MaxPartParser;
use InterpretSample\Parser\PartParsers\MinPartParser;
use InterpretSample\Parser\PartParsers\RequiredPartParser;
use InterpretSample\Parser\PartParsers\TypePartParser;

$parser = new Parser();

// добавление парсеров правил
$parser
    ->addPartParser(new RequiredPartParser())
    ->addPartParser(new TypePartParser())
    ->addPartParser(new MinPartParser())
    ->addPartParser(new MaxPartParser());
    
// парсинг правил и получение набора выражений для интерпретации
$rules = $parser->parse('required|string|min:3|max:32');

// создание контекста (хранилища данных интерпретации)
$context = new Context();

// установка значения для проверки
$rules->value->setValue('my string');

// интерпретация выражений (валидация значения)
$rules->evaluate($context);

// bool результат (соответствует ли значение правилам)
$result = $context->lookup($rules);

// коллекция ошибок
$errors = $context->errors();

// строка с ошибками
$errStr = (string)$context->errors();
```

### Ручная сборка

```php
use InterpretSample\Interpreter\Context;
use InterpretSample\Interpreter\LiteralExpression;
use InterpretSample\Interpreter\Rules\IntExpression;
use InterpretSample\Interpreter\Rules\MaxExpression;
use InterpretSample\Interpreter\Rules\MinExpression;
use InterpretSample\Interpreter\Rules\RequiredExpression;
use InterpretSample\Interpreter\RulesExpression;

// создание контекста (хранилище данных интерпретации)
$context = new Context();

// проверяемое значение, можно установить позже
$value = new LiteralExpression();

// сборка выражения правил
$rules = new RulesExpression(
    [
        new RequiredExpression($value),
        new IntExpression($value),
        new MinExpression($value, new LiteralExpression(1)),
        new MaxExpression($value, new LiteralExpression(100))
    ],
    $value
);

// установка значения для валидации
$value->setValue(15);

// интерпретация выражений (валидация значения)
$rules->evaluate($context);

// bool результат (соответствует ли значение правилам)
$result = $context->lookup($rules);

// коллекция ошибок
$errors = $context->errors();

// строка с ошибками
$errStr = (string)$context->errors();
```
