<?php

namespace gira\core;

abstract class Validation
{
    abstract public function rules(): array;

    public array $errors;

    public const REQUIRED  = 'required';
    public const MIN       = 'min';
    public const MAX       = 'max';
    public const EMAIL     = 'email';
    public const MATCH     = 'match';


    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }

                $this->validationRequired($ruleName, $value, $attribute, $rule);
                $this->validationEmail($ruleName, $value, $attribute, $rule);
                $this->validationMin($ruleName, $value, $attribute, $rule);
            }
        }
        return empty($this->errors);
    }

    protected function validationRequired($ruleName, $value, $attribute, $rule)
    {
        if ($ruleName === self::REQUIRED && !$value) {
            $this->addError($attribute, self::REQUIRED);
        }
    }

    protected function validationEmail($ruleName, $value, $attribute, $rule)
    {
        if ($ruleName === self::EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($attribute, self::EMAIL);
        }
    }

    protected function validationMin($ruleName, $value, $attribute, $rule)
    {

        if ($ruleName === self::MIN && strlen($value) < $rule['min']) {
            $this->addError($attribute, self::MIN, $rule);
        }
    }

    protected function validationMax($ruleName, $value, $attribute, $rule)
    {

        if ($ruleName === self::MAX && strlen($value) > $rule['max']) {
            $this->addError($attribute, self::MAX, $rule);
        }
    }

    protected function validationMatch($ruleName, $value, $attribute, $rule)
    {

        if ($ruleName === self::MATCH && $value !== $this->{$rule['match']}) {
            $this->addError($attribute, self::MATCH, $rule);
        }
    }

    public function addError(string $attribute, string $rules, $params = [])
    {
        $message = $this->errorMessages()[$rules] ?? 'none';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::REQUIRED => 'This filed is required',
            self::EMAIL    => 'This filed should be a valid email address',
            self::MIN      => 'This filed should not be less than {min}',
            self::MAX      => 'This filed should not be greater than {min}',
            self::MATCH    => 'This filed not matching {match}',
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
