<?php

use PHPUnit\Framework\TestCase;
use Memuya\Validator\Rules\Min;
use Memuya\Validator\ValidationResult;

final class MinTest extends TestCase
{
    const MIN_AMOUNT = 2;

    /** @test */
    public function testPropertiesAreSet()
    {
        $message = 'Validation message';
        $rule = new Min(self::MIN_AMOUNT, $message);

        $this->assertSame(self::MIN_AMOUNT, $rule->min);
        $this->assertSame($message, $rule->message);
    }

    /** @test */
    public function testFailedValidation()
    {
        $rule = new Min(self::MIN_AMOUNT);
        $result = $rule->validate(self::MIN_AMOUNT - 1);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid);
    }

    /** @test */
    public function testSuccessfulValidationWhenValueIsAboveMin()
    {
        $rule = new Min(self::MIN_AMOUNT);
        $result = $rule->validate(self::MIN_AMOUNT + 1);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid);
    }
}