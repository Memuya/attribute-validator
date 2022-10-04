<?php

use PHPUnit\Framework\TestCase;
use Memuya\Validator\ValidationResult;
use Memuya\Validator\Rules\LessThan;

final class LessThanTest extends TestCase
{
    const AMOUNT = 2;

    private string $message = 'Validation message';

    /** @test */
    public function testPropertiesAreSet()
    {
        $rule = new LessThan(self::AMOUNT, $this->message);

        $this->assertSame(self::AMOUNT, $rule->amount);
        $this->assertSame($this->message, $rule->message);
    }

    /** @test */
    public function testFailedValidationWhenValueIsGreaterThanAmount()
    {
        $rule = new LessThan(self::AMOUNT, $this->message);
        $result = $rule->validate(self::AMOUNT + 1);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid);
    }

    /** @test */
    public function testSuccessfulValidationWhenValueIsLessThanAmount()
    {
        $rule = new LessThan(self::AMOUNT, $this->message);
        $result = $rule->validate(self::AMOUNT);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid);
    }
}