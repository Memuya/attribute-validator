<?php

use PHPUnit\Framework\TestCase;
use Memuya\Validator\ValidationResult;
use Memuya\Validator\Rules\GreaterThan;

final class GreaterThanTest extends TestCase
{
    const AMOUNT = 2;

    private string $message = 'Validation message';

    /** @test */
    public function testPropertiesAreSet()
    {
        $rule = new GreaterThan(self::AMOUNT, $this->message);

        $this->assertSame(self::AMOUNT, $rule->amount);
        $this->assertSame($this->message, $rule->message);
    }

    /** @test */
    public function testFailedValidationWhenValueIsLessThanAmount()
    {
        $rule = new GreaterThan(self::AMOUNT, $this->message);
        $result = $rule->validate(self::AMOUNT);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid);
    }

    /** @test */
    public function testSuccessfulValidationWhenValueIsGreaterThanAmount()
    {
        $rule = new GreaterThan(self::AMOUNT, $this->message);
        $result = $rule->validate(self::AMOUNT + 1);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid);
    }
}