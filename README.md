# PHP Class Property Validator
A library that allows you to validate a classes properties using PHP attributes. Either use the built in validation rules or create your own!

# Basic Usage
For these examples we will be using this class as our test subject.

```php
class User
{
    private string $name;
    private int $age;
    private int $score;
}

$object = new User;
```

To add some validation rules to our `User` object, all we need to do is use one of the built in (or custom) validation rules on the properties of the class.

```php
use Memuya\Validator\Rules\Min;
use Memuya\Validator\Rules\Between;
use Memuya\Validator\Rules\Required;

class User
{
    #[Required(message: 'Name is required')]
    private string $name;

    #[Required(message: 'Age is required')]
    #[Min(min: 18, message: 'Age must be 18 or higher')]
    private int $age;

    #[Between(min: 50, max: 90, message: 'Score must be between 50 and 90')]
    private int $score;
}
```

Now pass the object to a new `Validator` instance, validate it and return the errors.

```php
use Memuya\Validator\Validator;

$validator = new Validator($object);

// Or shortcut using..
$validator = Validator::for($object);
```

```php
$validationErrors = $validator->validate()->getErrors();

// Or shortcut using..
$validationErrors = $validator->validateAndGetErrors();
```

This will return an associative array of `ValidationResult` objects where the key of each array element is the name of the property which failed validation.

You can then get the validation messages using the follows as an example.

```php
/** @var ValidationResult[] $errors */
/** @var string $field */
foreach ($validatorErrors as $field => $errors) {
	/** @var ValidationResult $validationResult */
	foreach ($errors as $validationResult) {
		print $validationResult->message.PHP_EOL;
	}
}
```

You can also check if validation has failed or passed using the following.

```php
$validator = Validator::for($object)->validate();

// At least 1 validation rule has failed.
if ($validator->failed()) {
    // ...
}

// All validation rules have passed.
if ($validator->passed()) {
    // ...
}
```

# Available Validation Rules
All rules are under the `Memuya\Validator\Rules` namespace.

- Between
- GreaterThan
- LessThan
- Min
- Required

# Custom Validation Rules
If you would like to use your own validation rules you can simply create a new PHP attribute that implements the `Validates` interface. Here, we'll create a validation rule that looks for an exact value to be match on the property.

```php

namespace My\Custom\Namespace;

use Attribute;
use Memuya\Validator\Validates;
use Memuya\Validator\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Match implements Validates
{
	public function __construct(public string $keyword, public string $message) {}
	
	public function validate(mixed $value): ValidationResult
	{
		if ($this->keyword !== $value) {
            return ValidationResult::invalid($this->message);
        }

        return ValidationResult::valid();
	}
}
```

Now you can use your validation rule in the same way as the built in ones on your object.

```php
use My\Custom\Namespace\Match;

class User
{
    #[Match(keyword: 'Bob', message: 'Your name must be Bob')]
    private string $name;
}
```