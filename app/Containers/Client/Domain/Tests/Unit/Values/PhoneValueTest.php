<?php

namespace App\Containers\Client\Domain\Tests\Unit\Values;

use App\Containers\Client\Domain\Exceptions\InvalidPhoneNumberException;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use App\Ship\Values\PhoneValue;

class PhoneValueTest extends TestCase
{
    /**
     * @dataProvider numberProvider
     */
    public function testPhoneValueThrowException($number)
    {
        $this->expectException(InvalidPhoneNumberException::class);

        new PhoneValue($number);
    }

    public function testPhoneValueGetValidData()
    {
        $this->assertEquals('+79991235599', (new PhoneValue('+79991235599'))->getValue());
    }

    public function numberProvider()
    {
        return [
            'empty number' => [''],
            '8 first' => ['89999999999'],
            '+78 first' => ['+78991235599'],
            'a lot number' => ['+799912355999'],
            'whitespace first' => [' +79991235599'],
            'too short' => ['+7999123559'],
        ];
    }
}
