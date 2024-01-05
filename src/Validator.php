<?php

namespace Memuya\Validator;

use ReflectionClass;
use ReflectionProperty;
use ReflectionAttribute;

class Validator
{
    /**
     * Holds all validation errors.
     *
     * @var array<string, ValidationResult>
     */
    private array $validationResults = [];

    /**
     * The object to be validated.
     *
     * @param object $object
     */
    private object $object;

    public function __construct(object $object)
    {
        $this->object = $object;
    }

    /**
     * Create a new Validator instance for the given object.
     *
     * @param object $object
     * @return self
     */
    public static function for(object $object): self
    {
        return new self($object);
    }

    /**
     * Validate the object and return the errors.
     *
     * @return array<string, ValidationResult>
     */
    public function validateAndGetErrors(): array
    {
        return $this->validate()->getErrors();
    }

    /**
     * Validate the object's properties.
     *
     * @return self
     */
    public function validate(): self
    {
        $reflection = new ReflectionClass($this->object);

        foreach ($reflection->getProperties() as $property) {
            $propertyValue = $this->getValueFromProperty($property);
            $validators = $property->getAttributes(Rule::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($validators as $validator) {
                $instance = $validator->newInstance();
                $validationResult = $instance->validate($propertyValue);

                if (!$validationResult->isValid) {
                    $this->addError($validationResult, $property);
                }
            }
        }

        return $this;
    }

    // public function validate(string $property): self
    // {
    //     $property = new ReflectionProperty($this->object, $property);
    //     $propertyValue = $this->getValueFromProperty($property);
    //     $validators = $property->getAttributes(Rule::class, ReflectionAttribute::IS_INSTANCEOF);

    //     foreach ($validators as $validator) {
    //         $instance = $validator->newInstance();
    //         $validationResult = $instance->validate($propertyValue);

    //         if (!$validationResult->isValid) {
    //             $this->addError($validationResult, $property);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * Return all validation errors.
     *
     * @return array<string, ValidationResult>
     */
    public function getErrors(): array
    {
        return $this->validationResults;
    }

    /**
     * Return all validation errors flattened into a single dimensional array.
     *
     * @return array<int, ValidationResult>
     */
    public function getErrorsFlattened(): array
    {
        // This needs to be stored in a variable to work with array_walk_recursive()
        // as it doesn't work with class properties.
        $errors = $this->getErrors();
        $flattenedErrors = [];

        array_walk_recursive($errors, function (ValidationResult $error) use (&$flattenedErrors) {
            $flattenedErrors[] = $error;
        });

        return $flattenedErrors;
    }

    /**
     * Check if validation has failed on any property on the object.
     *
     * @return bool
     */
    public function failed(): bool
    {
        return count($this->validationResults) > 0;
    }

    /**
     * Check if validation has passed on all property of the object.
     *
     * @return bool
     */
    public function passed(): bool
    {
        return count($this->validationResults) === 0;
    }

    /**
     * Add a validation error to the result set.
     *
     * @param ValidationResult $result
     * @param ReflectionProperty $property
     * @return void
     */
    private function addError(ValidationResult $result, ReflectionProperty $property): void
    {
        $this->validationResults[$property->getName()][] = $result;
    }

    /**
     * Return the value stored in the given property from the object being validated.
     *
     * @param ReflectionProperty $property
     * @return mixed
     */
    private function getValueFromProperty(ReflectionProperty $property): mixed
    {
        return $this->object->{$property->getName()} ?? null;
    }
}
