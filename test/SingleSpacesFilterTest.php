<?php

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\Filter\SingleSpaces;

class SingleSpacesFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider correctProvider
     */
    public function testCorrect($text, $expected)
    {
        $filter = new SingleSpaces();
        $result = $filter->filter($text);
        $this->assertEquals($expected, $result);
    }
 
    public static function correctProvider()
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