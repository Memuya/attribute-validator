<?php

use PHPUnit\Framework\TestCase;
use Memuya\Validator\Rules\Between;
use Memuya\Validator\ValidationResult;

final class BetweenTest extends TestCase
{
    const MIN_AMOUNT = 2;
    const MAX_AMOUNT = 5;

    /** @test */
    public function testPropertiesAreSet()
    {
        $message = 'Validation message';
        $rule = new Between(self::MIN_AMOUNT, self::MAX_AMOUNT, $message);

        $this->assertSame(self::MIN_AMOUNT, $rule->min);
        $this->assertSame(self::MAX_AMOUNT, $rule->max);
        $this->assertSame($message, $rule->message);
    }

    /** @test */
    public function testFailedValidationWhenBelowRange()
    {
        $rule = new Between(self::MIN_AMOUNT, self::MAX_AMOUNT);
        $result = $rule->validate(self::MIN_AMOUNT - 1);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid);
    }

    /** @test */
    public function testFailedValidationWhenOverRange()
    {
        $rule = new Between(self::MIN_AMOUNT, self::MAX_AMOUNT);
        $result = $rule->validate(self::MAX_AMOUNT + 1);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid);
    }

    /** @test */
    public function testSuccessfulValidationWhenValueIsInRange()
    {
        $rule = new Between(self::MIN_AMOUNT, self::MAX_AMOUNT);
        $result = $rule->validate(self::MIN_AMOUNT + 1);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid);
    }
}