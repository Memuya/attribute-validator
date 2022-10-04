<?php

namespace Memuya\Validator\Rules;

use Attribute;
use Memuya\Validator\Rule;
use Memuya\Validator\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class LessThan implements Rule
{
	public function __construct(public int $amount, public string $message) {}
	
	public function validate(mixed $value): ValidationResult
	{
		if ($value > $this->amount) {
            return ValidationResult::invalid($this->message);
        }

        return ValidationResult::valid();
	}
}
