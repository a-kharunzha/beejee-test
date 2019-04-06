<?php


namespace App\Exception;

abstract class ErrorArrayException extends \Exception
{
    private $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function __construct($message, array $errors)
    {
        $this->errors = $errors;
        parent::__construct($message);
    }

}
