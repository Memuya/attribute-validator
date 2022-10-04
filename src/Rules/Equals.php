<?php

namespace Memuya\Validator\Rules;

use Attribute;
use Memuya\Validator\Rule;
use Memuya\Validator\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Equals implements Rule
{
    public function __construct(public string $value, public string $message) {}

    public function validate(mixed $value): ValidationResult
    {
        if ($value !== $this->value) {
            return ValidationResult::invalid($this->message);
        }

        return ValidationResult::valid();
    }
}
