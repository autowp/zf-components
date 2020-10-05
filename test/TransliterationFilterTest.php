<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\Filter\Transliteration;
use PHPUnit\Framework\TestCase;

class TransliterationFilterTest extends TestCase
{
    /**
     * @dataProvider correctProvider
     */
    public function testCorrect(string $text, string $pattern): void
    {
        $filter = new Transliteration();
        $result = $filter->filter($text);
        $this->assertMatchesRegularExpression($pattern, $result);
    }

    public static function correctProvider(): array
    {
        return [
            [
                'абвгдеёжзиклмнопрстуфх ц ч ш щ ъыь эюя',
                '/^abvgdeezziklmnoprstufh c c s s ("|ʺ)y(ʹ|\') eua$/',
            ],
            ['Škoda', '/^Skoda$/'],
            ['数据库', '/^shu ju ku$/'],
        ];
    }
}
