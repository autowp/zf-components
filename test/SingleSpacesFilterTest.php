<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\Filter\SingleSpaces;
use PHPUnit\Framework\TestCase;

class SingleSpacesFilterTest extends TestCase
{
    /**
     * @dataProvider correctProvider
     */
    public function testCorrect(string $text, string $expected): void
    {
        $filter = new SingleSpaces();
        $result = $filter->filter($text);
        $this->assertEquals($expected, $result);
    }

    public static function correctProvider(): array
    {
        return [
            ['', ''],
            ['test', 'test'],
            [' test', ' test'],
            ['test ', 'test '],
            [' test ', ' test '],
            ['test test', 'test test'],
            ['test  test', 'test test'],
            ['test   test', 'test test'],
            ["test\ntest", "test\ntest"],
            ["test \ntest", "test \ntest"],
            ["test\n test", "test\n test"],
            ["test \ntest", "test \ntest"],
            ["test \n  test", "test \n test"],
        ];
    }
}
