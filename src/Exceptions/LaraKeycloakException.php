<?php

namespace PepperTech\LaraKeycloak\Exceptions;

use UnexpectedValueException;

class LaraKeycloakException extends UnexpectedValueException {
  public function __construct(string $message) {
    $this->message = "[LaraKeycloak] {$message}";
  }
}