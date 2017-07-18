<?php

namespace CognitiveFaceApi\Exception;

use CognitiveFaceApi\Component\FaceClient;

class InvalidMatchModeException extends \Exception
{
    const CODE = 100;

    /**
     * InvalidMatchModeException constructor.
     */
    public function __construct()
    {
        $message = sprintf(
            'Invalid match mode. Valid Modes: %s',
            implode(', ', FaceClient::getMatchModes())
        );

        parent::__construct($message, self::CODE);
    }
}
