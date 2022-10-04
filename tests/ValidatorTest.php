<?php

use Memuya\Validator\Rules\Min;
use Memuya\Validator\Validator;
use PHPUnit\Framework\TestCase;
use Memuya\Validator\Rules\Required;
use Memuya\Validator\ValidationResult;

final class ValidatorTest extends TestCase
{
    private object $object;

    public function setUp(): void
    {
        // The object we're going to validate.
        $this->object = new class {
            #[Required(message: 'Name is required')]
            public string $name;

            #[Required(message: 'Age is required')]
            #[Min(min: 18, message: 'Age must be 18 or greater')]
            public int $age;
        };
    }

    /** @test */
    public function testCanCreateInstance()
    {
        $this->assertInstanceOf(Validator::class, new Validator($this->object));
        $this->assertInstanceOf(Validator::class, Validator::for($this->object));
    }

    /** @test */
    public function testCanValidatePropertiesWithRulesAndReturnErrors()
    {
        $errors = Validator::for($this->object)->validate()->getErrors();
        $this->assertCount(2, $errors); // Both the 'name' and 'age' properties have validation errors.
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('age', $errors);
        $this->assertContainsOnlyInstancesOf(ValidationResult::class, $errors['name']);
        $this->assertContainsOnlyInstancesOf(ValidationResult::class, $errors['age']);

        // Now test via the validateAndGetErrors() method.
        $errors = Validator::for($this->object)->validateAndGetErrors();
        $this->assertCount(2, $errors); // Both the 'name' and 'age' properties have validation errors.
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('age', $errors);
        $this->assertContainsOnlyInstancesOf(ValidationResult::class, $errors['name']);
        $this->assertContainsOnlyInstancesOf(ValidationResult::class, $errors['age']);
    }

    /** @test */
    public function testCanValidatePropertiesWithRulesAndReturnErrorsFlattened()
    {
        $errors = Validator::for($this->object)->validate()->getErrorsFlattened();
        $this->assertCount(3, $errors);
        $this->assertContainsOnlyInstancesOf(ValidationResult::class, $errors);

        // Now test via the validateAndGetErrors() method.
        $errors = Validator::for($this->object)->validateAndGetErrors();
        $this->assertCount(2, $errors); // Both the 'name' and 'age' properties have validation errors.
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('age', $errors);
        $this->assertContainsOnlyInstancesOf(ValidationResult::class, $errors['name']);
        $this->assertContainsOnlyInstancesOf(ValidationResult::class, $errors['age']);
    }

    /** @test */
    public function testValidationPassesWhenRulesAreSatisfied()
    {
        $validator = Validator::for(new class {
            #[Required()]
            public string $name = 'Bob';
        })->validate();

        $this->assertTrue($validator->passed());
        $this->assertFalse($validator->failed());
    }

    /** @test */
    public function testValidationFailsWhenARuleIsNotSatisfied()
    {
        $validator = Validator::for(new class {
            #[Required()]
            public string $name;
        })->validate();

        $this->assertTrue($validator->failed());
        $this->assertFalse($validator->passed());
    }
}