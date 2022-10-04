<?php

namespace Memuya\Validator;

class ValidationResult
{
    public function __construct(
        public bool $isValid,
        public ?string $message = null,
    ) {}

    /**
     * Create a valid ValidationResult instance.
     *
     * @return self
     */
    public static function valid(): self
    {
        return new self(
            isValid: true,
        );
    }

    /**
     * Return an invalid ValidationResult instance.
     *
     * @param string $message
     * @return self
     */
    public static function invalid(string $message): self
    {
        return new self(
            isValid: false,
            message: $message,
        );
    }
}
