<?php

namespace Memuya\Validator\Rules;

use Attribute;
use Memuya\Validator\Rule;
use Memuya\Validator\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Min implements Rule
{
	public function __construct(public int $min, public ?string $message = null) {}
	
	public function validate(mixed $value): ValidationResult
	{
		if ($value < $this->min) {
            return ValidationResult::invalid($this->message ?? "'{$value}' must be at least {$this->min}");
        }

        return ValidationResult::valid();
	}
}
