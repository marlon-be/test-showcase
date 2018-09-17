<?php

namespace App\Tests\Email;

use App\Email\MailNameFormatter;
use PHPUnit\Framework\TestCase;

/**
 * This is a unit test that tests the functionality of an isolated class
 * A good reason to use PHPUnit here instead of PHPSpec is the ability to use dataProviders
 * This way, a long list of input/output sets can be tested, while requiring little work by the developer
 * Whenever a bug with this class if found, the input for which the output was incorrect can easily be added
 */
final class MailNameFormatterTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideNames
     */
    public function it_should_format_names_correctly(string $name, string $expectedResult) : void
    {
        self::assertEquals($expectedResult, MailNameFormatter::formatName($name));
    }

    public function provideNames() : array
    {
        return [
            ['john.johnson', 'John Johnson'],
            ['patricia-davis', 'Patricia Davis'],
            ['michaelbrown', 'Michaelbrown'],
            ['susan_miller', 'Susan Miller'],
        ];
    }
}
