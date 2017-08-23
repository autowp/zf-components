<?php

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\Filter\FilenameSafe;

class FilenameSafeFilterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider correctProvider
     */
    public function testCorrect($text, $expected)
    {
        $filter = new FilenameSafe();
        $result = $filter->filter($text);
        $this->assertEquals($expected, $result);
    }

    public static function correctProvider()
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
            ['Škoda', 'skoda']
        ];
    }
}
