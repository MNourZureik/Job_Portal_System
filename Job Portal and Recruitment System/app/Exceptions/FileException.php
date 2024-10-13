<?php

namespace App\Exceptions;

use Exception;

class FileException extends Exception
{
    // Custom message and status code (optional)
    protected $message;
    protected $code;

    public function __construct($message = "File operation failed", $code = 500)
    {
        parent::__construct($message, $code);
    }

    // You can also customize the report method if you want to log it differently
    public function report()
    {
        // Log the exception or send to an error reporting system
        //Log::error($this->getMessage());
    }

    // Customize the render method for how this exception is shown
    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->code);
    }
}

