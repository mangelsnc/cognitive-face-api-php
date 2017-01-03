<?php

namespace CognitiveFaceApi\Exception;

use Symfony\Component\HttpFoundation\Response;

class ConcurrentOperationConflictException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message, Response::HTTP_CONFLICT);
    }
}