<?php

use Memuya\Validator\Validator;
use PHPUnit\Framework\TestCase;
use Memuya\Validator\Rules\Required;
use Memuya\Validator\ValidationResult;

final class ValidationResultTest extends TestCase
{
    /** @test */
    public function testValidStateCanBeCreated()
    {
        $validationResult = ValidationResult::valid();

        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertTrue($validationResult->isValid);
    }

    /** @test */
    public function testInvalidStateCanBeCreated()
    {
        $message = 'Validation message';
        $validationResult = ValidationResult::invalid($message);

        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertFalse($validationResult->isValid);
        $this->assertSame($message, $validationResult->message);
    }
}