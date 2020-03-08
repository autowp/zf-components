<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\Filter\FilenameSafe;
use PHPUnit\Framework\TestCase;

class FilenameSafeFilterTest extends TestCase
{
    /**
     * @dataProvider correctProvider
     */
    public function testCorrect(string $text, string $expected): void
    {
        $filter = new FilenameSafe();
        $result = $filter->filter($text);
        $this->assertEquals($expected, $result);
    }

    public static function correctProvider(): array
    {
        return [
            ['just.test', 'just.test'],
            ['.', '_'],
            ['..', '__'],
            ['...', '...'],
            ['', '_'],
            ['just test', 'just_test'],
            ['просто тест ', 'prosto_test'],
            ['数据库', 'shu_ju_ku'],
            ['Škoda', 'skoda'],
        ];
    }
}
