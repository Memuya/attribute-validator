<?php

use Memuya\Validator\Rules\Equals;
use PHPUnit\Framework\TestCase;
use Memuya\Validator\ValidationResult;

final class EqualsTest extends TestCase
{
    /** @test */
    public function testMessageCanBeSet()
    {
        $value = 'Test';
        $message = 'Validation message';
        $rule = new Equals($value, $message);

        $this->assertSame($message, $rule->message);
    }

    /** @test */
    public function testFailedValidation()
    {
        $value = 'Test';
        $rule = new Equals($value, 'Validation message');
        $result = $rule->validate('Incorrect value');

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid);
    }

    /** @test */
    public function testSuccessfulValidationWhenValuesAreEqual()
    {
        $value = 'Test';
        $rule = new Equals($value, 'Validation message');
        $result = $rule->validate($value);

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid);
    }
}