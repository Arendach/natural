<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Log;

class FileNotFoundException extends Exception
{
    private array $source;

    public function __construct($message = '', $source = [], $code = 0, Throwable $previous = null)
    {
        $this->source = $source;

        parent::__construct($message, $code, $previous);
    }

    public function report(): void
    {
        Log::error(
            $this->getMessage() . PHP_EOL . $this->getFile() . PHP_EOL . $this->getTraceAsString(),
            $this->source
        );
    }
}