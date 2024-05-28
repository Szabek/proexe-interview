<?php

namespace App\Exceptions;

use Exception;

class NoAuthAdapterFoundException extends Exception
{
    protected $message = 'No authentication adapter found for the provided login.';
}
