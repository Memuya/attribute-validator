<?php

use PHPUnit\Framework\TestCase;
use Memuya\Validator\Rules\Required;
use Memuya\Validator\ValidationResult;

final class RequiredTest extends TestCase
{
    /** @test */
    public function testMessageCanBeSet()
    {
        $message = 'Validation message';
        $rule = new Required($message);

        $this->assertSame($message, $rule->message);
    }

    /** @test */
    public function testFailedValidation()
    {
        $rule = new Required();
        $result = $rule->validate('');

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertFalse($result->isValid);
    }

    /** @test */
    public function testSuccessfulValidationWhenValueIsNotEmpty()
    {
        $rule = new Required();
        $result = $rule->validate('Passes validation');

        $this->assertInstanceOf(ValidationResult::class, $result);
        $this->assertTrue($result->isValid);
    }
}