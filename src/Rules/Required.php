<?php

namespace Memuya\Validator\Rules;

use Attribute;
use Memuya\Validator\Rule;
use Memuya\Validator\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required implements Rule
{
	public function __construct(public ?string $message = null) {}
	
	public function validate(mixed $value): ValidationResult
	{
		if (empty($value)) {
            return ValidationResult::invalid($this->message ?? 'Field is required');
        }

        return ValidationResult::valid();
	}
}
