<?php
declare(strict_types=1);

namespace LessDatabaseTest\Query\Builder\Helper;

use LessDatabase\Query\Builder\Helper\LabelHelper;
use LessValueObject\Enum\EnumValueObject;
use LessValueObject\Number\Int\IntValueObject;
use LessValueObject\Number\NumberValueObject;
use LessValueObject\String\StringValueObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LessDatabase\Query\Builder\Helper\LabelHelper
 */
final class LabelHelperTest extends TestCase
{
    /**
     * @dataProvider getFieldValueTests
     */
    public function testCreateFieldValueKey(string|int|bool|float|EnumValueObject|NumberValueObject|StringValueObject|null $value, string $expectedKey): void
    {
        self::assertSame($expectedKey, LabelHelper::fromValue($value));
    }

    /**
     * @return array<array<mixed>>
     */
    public function getFieldValueTests(): iterable
    {
        $enum = $this->createMock(EnumValueObject::class);
        $enum->method('getValue')->willReturn('enum');

        $number = $this->createMock(IntValueObject::class);
        $number->method('getValue')->willReturn(3);

        $string = $this->createMock(StringValueObject::class);
        $string->method('__toString')->willReturn('string');

        return [
            [true, 'b_true'],
            [false, 'b_false'],
            [null, 'null'],
            [1, 'i_pos_1'],
            [-1, 'i_neg_1'],
            [1.1, 'sf_777d45bbbcdf50d49c42c70ad7acf5fe'],
            ['foobar', 'sf_3858f62230ac3c915f300c664312c63f'],
            [$enum, 'sf_da45ec4be6574774008df9be683a4778'],
            [$number, 'i_pos_3'],
            [$string, 'sf_b45cffe084dd3d20d928bee85e7b0f21'],
        ];
    }
}
