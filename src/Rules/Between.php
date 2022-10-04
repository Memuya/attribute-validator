<?php

namespace Memuya\Validator\Rules;

use Attribute;
use Memuya\Validator\Rule;
use Memuya\Validator\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Between implements Rule
{
    public function __construct(public int $min, public int $max, public ?string $message = null) {}

    public function validate(mixed $value): ValidationResult
    {
        if ($value < $this->min || $value > $this->max) {
            return ValidationResult::invalid($this->message ?? "Must be between {$this->min} and {$this->max}");
        }

        return ValidationResult::valid();
    }
}
