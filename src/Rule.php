<?php

namespace Memuya\Validator;

use Memuya\Validator\ValidationResult;

interface Rule
{
	/**
	 * Validate the given value.
	 *
	 * @param mixed $value
	 * @return ValidationResult
	 */
	public function validate(mixed $value): ValidationResult;
}
